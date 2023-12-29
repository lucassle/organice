<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;

class RecallModel extends AdminModel {
    public function __construct() {
        $this->table                = 'recall';
        $this->folderUpload         = 'recall';
        $this->fieldSearchAccepted  = ['id', 'phone_number'];
        $this->crudNotAccepted      = ['_token'];
    }

    public function listItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == "admin-list-items") {
            $query     = $this->select('id', 'phone_number', 'time_request', 'status');
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
        if ($option['task'] == 'get-items') {
            $result = self::select('id', 'username', 'fullname', 'email', 'status', 'avatar', 'level', 'password')->where('id', $arrParam['id'])->first();
        }

        if ($option['task'] == 'news-list-items-in-category') {
            $result = self::select('id', 'username', 'display')->where('id', $arrParam['category_id'])->first();
            if($result){
                $result = $result->toArray();
            }
        }

        if ($option['task'] == 'get-avatar') {
            $result = self::select('id', 'avatar')->where('id', $arrParam['id'])->first();
        }

        if ($option['task'] == 'get-password') {
            $result = self::select('id', 'password')->where('id', $arrParam['id'])->first()->toArray();
        }

        if ($option['task'] == 'auth-login') {
            $result = self::select('id', 'username', 'fullname', 'email', 'avatar', 'level')
                            ->where('status', 'active')
                            ->where('email', $arrParam['email'])
                            ->where('password', md5($arrParam['password']))
                            ->first();
            if ($result) $result    = $result->toArray();
        }

        return $result;
    }

    public function saveItems($arrParam = null, $option = null) {
        $result = '';
        if ($option['task'] == "add-items") {
            $arrParam['time_request']   = date('Y-m-d H:i:s');
            $arrParam['status']         = 'waiting';
            $result = self::insert($this->prepareParams($arrParam));
        }

        if ($option['task'] == "change-status") {
            $status = ($arrParam['status'] == 'waiting') ? 'contacted' : 'waiting';
            self::where('id', $arrParam['id'])->update(['status' => $status]);
            $result = ['id' => $arrParam["id"]];
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
