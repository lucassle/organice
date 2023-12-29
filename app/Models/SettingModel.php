<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;

class SettingModel extends AdminModel {
    public function __construct() {
        $this->table                = 'setting';
        $this->fieldSearchAccepted  = ['key_value'];
        $this->crudNotAccepted      = ['_token', 'email_bcc_task', 'email_account_task'];
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
        if ($option['task'] == "general") {
            $arrParam['logo']   = $this->uploadThumb($arrParam['logo']);
            $value              = json_encode($this->prepareParams($arrParam), JSON_UNESCAPED_UNICODE);
            $keyValue           = 'setting-general';
            $result             = $this->where('key_value', $keyValue)->update(['value' => $value]);
        }

        if ($option['task'] == "social") {
            $value          = json_encode($this->prepareParams($arrParam), JSON_UNESCAPED_UNICODE);
            $keyValue       = 'setting-social';
            $result         = $this->where('key_value', $keyValue)->update(['value' => $value]);
        }

        if ($option['task'] == "email-account") {
            $value          = json_encode($this->prepareParams($arrParam), JSON_UNESCAPED_UNICODE);
            $keyValue       = 'setting-email-account';
            $result         = $this->where('key_value', $keyValue)->update(['value' => $value]);
        }

        if ($option['task'] == "email-bcc") {
            $value          = json_encode($this->prepareParams($arrParam), JSON_UNESCAPED_UNICODE);
            $keyValue       = 'setting-email-bcc';
            $result         = $this->where('key_value', $keyValue)->update(['value' => $value]);
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
