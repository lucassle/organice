<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;

class ProductModel extends AdminModel {
    // use HasFactory;
    public function __construct() {
        $this->table                = 'product as p';
        $this->folderUpload         = 'product';
        $this->fieldSearchAccepted  = ['id', 'name', 'description'];
        $this->crudNotAccepted      = ['_token', 'thumb_current', 'taskCategory'];
    }

    public function listItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == "admin-list-items") {
            $query     = $this->select('p.id', 'p.name', 'c.name as category', 'p.description', 'p.price', 'p.status', 'p.thumb', 'p.type', 'p.sale_off', 'p.meta_title', 'p.meta_description')
                              ->leftJoin('category_product as c', 'p.category_id', '=', 'c.id');
            if ($arrParam['filter']['status'] !== "all") {
                $query->where('p.status', '=', $arrParam['filter']['status']);
            }

            if ($arrParam['search']['value'] !== "") {
                if ($arrParam['search']['field'] == "all") {
                    $query->where(function($query) use ($arrParam) {
                        foreach ($this->fieldSearchAccepted as $value) {
                            $query->orWhere('p.' . $value, "LIKE", "%{$arrParam['search']['value']}%");
                        }
                    });
                } else if (in_array($arrParam['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where('p.' . $arrParam['search']['field'], "LIKE", "%{$arrParam['search']['value']}%");
                }
            }
            $result     = $query->orderBy('p.id', 'desc')
                                ->paginate($arrParam['pagination']['totalItemPerPage']);
        }

        if ($option['task'] == "shop-list-items-slider") {
            $query      = $this->select('p.id', 'p.category_id', 'c.name as category', 'p.thumb')
                              ->leftJoin('category_product as c', 'p.category_id', '=', 'c.id')
                              ->where('p.status', '=', 'active')
                              ->orderBy('p.id', 'asc')
                              ->take(5);
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == "shop-list-items-feature") {
            $query      = $this->select('p.id', 'p.name', 'p.category_id', 'c.name as category', 'p.thumb', 'p.price', 'p.sale_off')
                              ->leftJoin('category_product as c', 'p.category_id', '=', 'c.id')
                              ->where('p.status', '=', 'active')
                              ->where('p.type', 'feature')
                              ->take(8);
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == "shop-list-items-latest") {
            $query      = $this->select('p.id', 'p.category_id', 'p.name', 'c.name as category', 'p.thumb', 'p.price', 'p.sale_off')
                              ->leftJoin('category_product as c', 'p.category_id', '=', 'c.id')
                              ->where('p.status', '=', 'active')
                              ->orderBy('p.id', 'desc')
                              ->take(3);
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == "shop-list-items-related") {
            $query = self::select('id', 'name', 'description', 'thumb', 'price', 'sale_off')
                            ->where('status', '=', 'active')
                            ->where('id', '!=', $arrParam['id'])
                            ->where('category_id', '=', $arrParam['category_id'])
                            ->take(5);
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == "shop-list-items-sale-off") {
            $query      = $this->select('p.id', 'p.name', 'c.name as category', 'p.price', 'p.thumb', 'p.sale_off', 'p.quantity')
                                ->leftJoin('category_product as c', 'p.category_id', '=', 'c.id')                   
                                ->where('p.status', '=', 'active')
                                ->where('p.sale_off', '>', '0')
                                // ->where('p.category_id', '=', $arrParam['category_id'])
                                ->take(5);
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == 'shop-list-items') {
            $query      = $this->select('p.id', 'p.name', 'c.name as category', 'p.price', 'p.thumb', 'p.sale_off', 'p.quantity')
                                ->leftJoin('category_product as c', 'p.category_id', '=', 'c.id')                   
                                ->where('p.status', '=', 'active');
                                // ->where('p.category_id', '=', $arrParam['category_id'])
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == 'shop-list-items-in-category') {
            $query      = $this->select('id', 'name', 'price', 'thumb', 'sale_off', 'quantity')     
                                ->where('status', '=', 'active')
                                ->where('category_id', '=', $arrParam['category_id']);
            $result     = $query->get()->toArray(); 
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
        if ($option['task'] == 'get-items') {
            $result = self::select('p.id', 'p.name', 'p.price', 'p.description', 'p.thumb', 'p.status', 'p.category_id', 'c.name as category', 'p.meta_title', 'p.meta_description')
                            ->leftJoin('category_product as c', 'p.category_id', '=', 'c.id')
                            ->where('p.id', $arrParam['id'])->first();
        }

        if ($option['task'] == 'get-thumb') {
            $result = self::select('id', 'thumb')->where('id', $arrParam['id'])->first();
        }

        
        if ($option['task'] == 'shop-get-items') {
            $result = self::select('p.id', 'p.category_id', 'p.name', 'p.description', 'p.thumb', 'p.price', 'p.sale_off', 'p.quantity','c.name as category', 'p.publish_at')
                            ->leftJoin('category_product as c', 'p.category_id', '=', 'c.id')
                            ->where('p.id', $arrParam['product_id'])
                            ->where('p.status', '=', 'active')->first();
            if($result){
                $result = $result->toArray();
            }
        }

        return $result;
    }

    public function saveItems($arrParam = null, $option = null) {
        $result = '';
        if ($option['task'] == "change-status") {
            $status = ($arrParam['status'] == 'active') ? 'inactive' : 'active';
            $modifiedBy = session("userInfo")["username"];
            $modified   = date('Y-m-d H:i:s');
            self::where('id', $arrParam['id'])
                ->update(['status' => $status, 'modified_by' => $modifiedBy, 'modified' => $modified]);
            $result = [
                'id'        => $arrParam["id"],
                'modified'  => Template::showItemHistory($modifiedBy, $modified),
            ];
        }

        if ($option['task'] == "change-type") {
            $type   = $arrParam['type'];
            $modifiedBy = session("userInfo")["username"];
            $modified   = date('Y-m-d H:i:s');
            self::where('id', $arrParam['id'])
                ->update(['type' => $type, 'modified_by' => $modifiedBy, 'modified' => $modified]);
            $result = [
                'id'        => $arrParam["id"],
                'modified'  => Template::showItemHistory($modifiedBy, $modified),
            ];
        }

        if ($option['task'] == "add-item") {
            $arrParam['thumb']          = $this->uploadThumb($arrParam['thumb']);
            $arrParam['created_by']     = 'admin';
            $arrParam['created']        = date('Y-m-d');
            // echo '<pre style="color: red;">';
            // print_r($arrParam);
            // echo '</pre>';
            // die('Function is called');
            self::insert($this->prepareParams($arrParam));
        }

        if ($option['task'] == "edit-item") {
            if (!empty($arrParam['thumb'])) {
                $this->deleteThumb($arrParam['thumb_current']);
                $arrParam['thumb']      = $this->uploadThumb($arrParam['thumb']);
            }
            $arrParam['modified_by']    = 'admin';
            $arrParam['modified']       = date('Y-m-d');

            self::where('id', $arrParam['id'])->update($this->prepareParams($arrParam));
        }

        if ($option['task'] == "change-category") {
            $category   = $arrParam['category_id'];
            $result     = self::where('id', $arrParam['id'])
                ->update(['category_id' => $category]);
        }
        return $result;
    }

    public function deleteItems($arrParam = null, $option = null) {
        if ($option['task'] == "delete-item") {
            $items  = self::getItems($arrParam, ['task' => 'get-thumb']);
            $this->deleteThumb($items['thumb']);
            self::where('id', $arrParam['id'])->delete();
        }
    }
}

