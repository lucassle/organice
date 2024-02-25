<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Helpers\Template;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class CartModel extends AdminModel {
    public function __construct() {
        $this->table                = 'cart';
        $this->fieldSearchAccepted  = ['key_value'];
        $this->crudNotAccepted      = ['_token'];
        $this->timestamps           = false;
    }

    public function listItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == "admin-list-items") {
            $query     = $this->select('id', 'username', 'fullname', 'email', 'level', 'avatar', 'status', 'created', 'created_by', 'modified', 'modified_by');
            if ($arrParam['filter']['status'] !== "all") {
                $query->where('status', '=', $arrParam['filter']['status']);
            }

            if ($arrParam['search']['value'] !== "") {
                if ($arrParam['search']['field'] == "all") {
                    $query->where(function($query) use ($arrParam) {
                        foreach ($this->fieldSearchAccepted as $value) {
                            $query->orWhere($value, "LIKE", "%{$arrParam['search']['value']}%");
                        }
                    });
                } else if (in_array($arrParam['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($arrParam['search']['field'], "LIKE", "%{$arrParam['search']['value']}%");
                }
            }
            $result     = $query->orderBy('id', 'desc')
                                ->paginate($arrParam['pagination']['totalItemPerPage']);
        }
        
        return $result;
    }

    public function countItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == "admin-count-items") {
            $query     = self::groupBy('status')
                            ->select('status', DB::raw('count(id) as count, status'));
            if ($arrParam['search']['value'] !== "") {
                if ($arrParam['search']['field'] == "all") {
                    $query->where(function($query) use ($arrParam) {
                        foreach ($this->fieldSearchAccepted as $value) {
                            $query->orWhere($value, "LIKE", "%{$arrParam['search']['value']}%");
                        }
                    });
                } else if (in_array($arrParam['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($arrParam['search']['field'], "LIKE", "%{$arrParam['search']['value']}%");
                }
            }
            $result = $query->get()->toArray();
        }

        if ($option['task'] == "count-by-items") {
            $query     = self::select(DB::raw('count(id) as count'));
            $result = $query->get()->toArray();
        }
        
        return $result;
    }

    public function getItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == 'general') {
            $items = $this->select('value')->where('key_value', 'setting-general')->firstOrFail()->toArray();
            $result = json_decode($items['value'], true);
        }

        if ($option['task'] == 'social') {
            $items = $this->select('value')->where('key_value', 'setting-social')->firstOrFail()->toArray();
            $result = json_decode($items['value'], true);
        }

        if ($option['task'] == 'email-account') {
            $items = $this->select('value')->where('key_value', 'setting-email-account')->firstOrFail()->toArray();
            $result = json_decode($items['value'], true);
        }

        if ($option['task'] == 'email-bcc') {
            $items = $this->select('value')->where('key_value', 'setting-email-bcc')->firstOrFail()->toArray();
            $result = json_decode($items['value'], true);
        }

        return $result;
    }

    public function saveItems($arrParam = null, $option = null) {
        $result = '';
        if ($option['task'] == "add-items") {
            $cart                       = Cart::content()->toArray();
            // echo '<pre style="color: red;">';
            // print_r($cart);
            // echo '</pre>';
            // die('Function is called');
            $arrParam['time']           = date('Y-m-d');
            $arrParam['status']         = 'confirming';
            $arrParam['username']       = session('userInfo')['username'];
            // $arrParam['product']        = json_encode($cart['name'] . '*' . $cart['qty'], JSON_UNESCAPED_UNICODE);
            // $arrParam['total_price']    = $cart['subtotal'] + $cart['tax'];
            $arrParam['payment']        = 'COD';

            $result = self::insert($this->prepareParams($arrParam));
        }

        return $result;
    }

    public function deleteItems($arrParam = null, $option = null) {
        if ($option['task'] == "delete-item") {
            $items  = self::getItems($arrParam, ['task' => 'get-avatar']);
            $this->deleteThumb($items['avatar']);
            self::where('id', $arrParam['id'])->delete();
        }
    }
}
