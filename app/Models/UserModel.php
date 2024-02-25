<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;

class UserModel extends AdminModel {
    public function __construct() {
        $this->table                = 'user';
        $this->folderUpload         = 'user';
        $this->fieldSearchAccepted  = ['id', 'username', 'fullname', 'email'];
        $this->crudNotAccepted      = ['_token', 'avatar_current', 'password_confirmation', 'taskInfo', 'taskAdd'];
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

        if ($option['task'] == 'get-info') {
            $result = self::select('id', 'username', 'password')->where('id', session('userInfo')['id'])->first()->toArray();
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

        if ($option['task'] == "change-level") {
            $level    = $arrParam['level'];
            $modifiedBy = session("userInfo")["username"];
            $modified   = date('Y-m-d H:i:s');
            self::where('id', $arrParam['id'])
                ->update(['level' => $level, 'modified_by' => $modifiedBy, 'modified' => $modified]);
            $result = [
                'id'        => $arrParam["id"],
                'modified'  => Template::showItemHistory($modifiedBy, $modified),
            ];
        }

        if ($option['task'] == "change-password") {
            $password    = md5($arrParam['password']);
            $result = self::where('id', $arrParam['id'])
                ->update(['password' => $password]);
        }

        if ($option['task'] == "change-level-post") {
            $level    = $arrParam['level'];
            $result = self::where('id', $arrParam['id'])->update(['level' => $level]);
        }

        if ($option['task'] == "add-item") {
            $arrParam['created_by']     = 'admin';
            $arrParam['created']        = date('Y-m-d');
            $arrParam['password']       = md5($arrParam['password']);
            $arrParam['avatar']         = $this->uploadThumb($arrParam['avatar']);
            $result = self::insert($this->prepareParams($arrParam));
        }

        if ($option['task'] == "edit-info") {
            if (!empty($arrParam['avatar'])) {
               $this->deleteThumb($arrParam['avatar_current']);
               $arrParam['avatar']         = $this->uploadThumb($arrParam['avatar']);
            }
            $arrParam['modified_by']    = 'admin';
            $arrParam['modified']       = date('Y-m-d');
            $result = self::where('id', $arrParam['id'])->update($this->prepareParams($arrParam));
        }

        if ($option['task'] == "change-password-post") {
            $password   = md5($arrParam['password']);
            $result     = self::where('id', $arrParam['id'])
                ->update(['password' => $password]);
        }

        if ($option['task'] == "change-password-info") {
            $password   = md5($arrParam['new_password']);
            $result     = self::where('id', $arrParam['id'])
                ->update(['password' => $password]);
        }

        if ($option['task'] == "add-new-user") {
            $arrParam['created_by']     = $arrParam['username'];
            $arrParam['created']        = date('Y-m-d');
            $arrParam['password']       = md5($arrParam['password']);
            $arrParam['level']          = 'member';
            $arrParam['status']         = 'active';
            $arrParam['avatar']         = $this->uploadThumb($arrParam['avatar']);

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
