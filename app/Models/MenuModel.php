<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;

class MenuModel extends AdminModel {
    // use HasFactory;
    public function __construct() {
        $this->table                = 'menu';
        $this->folderUpload         = 'menu';
        $this->fieldSearchAccepted  = ['id', 'link', 'name'];
        $this->crudNotAccepted      = ['_token'];
    }

    public function listItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == "admin-list-items") {
            $query     = $this->select('id', 'name', 'status', 'link', 'ordering', 'type_menu', 'type_open');
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
            $result     = $query->orderBy('id', 'asc')
                                ->paginate($arrParam['pagination']['totalItemPerPage']);
        }

        if ($option['task'] == "shop-list-items") {
            $query      = $this->select('id', 'name', 'link', 'type_menu', 'type_open')
                                ->where('status', 'active')
                                ->orderBy('ordering', 'asc');
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
            $result = self::select('id', 'name', 'link', 'ordering', 'status', 'type_menu', 'type_open')->where('id', $arrParam['id'])->first();
        }

        return $result;
    }

    public function saveItems($arrParam = null, $option = null) {
        $result = '';
        if ($option['task'] == "change-status") {
            $status = ($arrParam['status'] == 'active') ? 'inactive' : 'active';
            self::where('id', $arrParam['id'])
                ->update(['status' => $status]);
            $result = [
                'id'        => $arrParam["id"],
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

            return $result;
        }

        if ($option['task'] == "change-type-menu") {
            $typeMenu   = $arrParam['type_menu'];
            self::where('id', $arrParam['id'])
                ->update(['type_menu' => $typeMenu]);
            $result = [
                'id'        => $arrParam["id"],
                'message'   => config('return.notify.success.update')
            ];
        }

        if ($option['task'] == "change-type-open") {
            $typeOpen     = $arrParam['type_open'];
            self::where('id', $arrParam['id'])
                ->update(['type_open' => $typeOpen]);
            $result = [
                'id'        => $arrParam["id"],
                'message'   => config('return.notify.success.update')
            ];
        }

        if ($option['task'] == "add-item") {
            $arrParam['created_by']     = 'admin';
            $arrParam['created']        = date('Y-m-d');
            self::insert($this->prepareParams($arrParam));
        }

        if ($option['task'] == "edit-item") {
            self::where('id', $arrParam['id'])->update($this->prepareParams($arrParam));
        }
        return $result;
    }

    public function deleteItems($arrParam = null, $option = null) {
        if ($option['task'] == "delete-item") {
            self::where('id', $arrParam['id'])->delete();
        }
    }
}
