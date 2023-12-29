<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;

class BannerModel extends AdminModel {
    // use HasFactory;
    public function __construct() {
        $this->table                = 'banner';
        $this->folderUpload         = 'banner';
        $this->fieldSearchAccepted  = ['id', 'name', 'description', 'link'];
        $this->crudNotAccepted      = ['_token', 'thumb_current'];
    }

    public function listItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == "admin-list-items") {
            $query     = $this->select('id', 'name', 'description', 'link', 'thumb', 'status', 'ordering', 'created', 'created_by', 'modified', 'modified_by');
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

        if ($option['task'] == "shop-list-items-banner") {
            $query      = $this->select('id', 'name', 'description', 'link', 'thumb')
                                ->where('status', '=', 'active')
                                ->orderBy('ordering', 'desc')
                                ->limit(5);
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
            $result = self::select('id', 'name', 'description', 'link', 'thumb', 'status')->where('id', $arrParam['id'])->first();
        }

        if ($option['task'] == 'get-thumb') {
            $result = self::select('id', 'thumb')->where('id', $arrParam['id'])->first();
        }

        return $result;
    }

    public function saveItems($arrParam = null, $option = null) {
        $result = '';
        if ($option['task'] == "change-status") {
            $status = ($arrParam['status'] == 'active') ? 'inactive' : 'active';
            // $modifiedBy = session("userInfo")["username"];
            // $modified   = date('Y-m-d H:i:s');
            self::where('id', $arrParam['id'])
                ->update(['status' => $status]);
            $result = [
                'id'        => $arrParam["id"],
                // 'modified'  => Template::showItemHistory($modifiedBy, $modified),
                'message'   => config('return.notify.success.update')
            ];
        }

        if ($option['task'] == "change-ordering") {
            $result     = '';
            $ordering = $arrParam['ordering'];
            self::where('id', $arrParam['id'])->update(['ordering' => $ordering]);

            $result = [
                'id'        => $arrParam["id"],
                'message'   => config('return.notify.success.update')
            ];
        }

        if ($option['task'] == "add-item") {
            $arrParam['thumb']      = $this->uploadThumb($arrParam['thumb']);
            $arrParam['created_by']     = 'admin';
            $arrParam['created']        = date('Y-m-d');
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
