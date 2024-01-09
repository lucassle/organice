<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;

class ContactModel extends AdminModel {
    // use HasFactory;
    public function __construct() {
        $this->table                = 'contact';
        $this->folderUpload         = 'contact';
        $this->fieldSearchAccepted  = ['name', 'email', 'phone', 'message'];
        $this->crudNotAccepted      = [];
    }

    public function listItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == "admin-list-items") {
            $query     = $this->select('id', 'name', 'email', 'phone', 'message', 'status', 'time', 'ip_address');
            if ($arrParam['filter']['status'] !== "all") {
                $query->where('status', '=', $arrParam['filter']['status']);
            }

            if ($arrParam['search']['value'] !== "") {
                if ($arrParam['search']['field'] == "all") {
                    $query->where(function($query) use ($arrParam) {
                        foreach ($this->fieldSearchAccepted as $value) {
                            $query->orWhere('' . $value, "LIKE", "%{$arrParam['search']['value']}%");
                        }
                    });
                } else if (in_array($arrParam['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where('' . $arrParam['search']['field'], "LIKE", "%{$arrParam['search']['value']}%");
                }
            }
            $result     = $query->orderBy('id', 'desc')
                                ->paginate($arrParam['pagination']['totalItemPerPage']);
        }

        if ($option['task'] == "shop-list-items-blog") {
            $query      = $this->select('id', 'title', 'content', 'thumb', 'created')
                              ->where('status', '=', 'active')
                              ->orderBy('id', 'asc')
                              ->take(3);
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == "shop-list-items-feature") {
            $query      = $this->select('id', 'name', 'category_id', 'c.name as category', 'thumb', 'price')
                              ->leftJoin('category as c', 'category_id', '=', 'c.id')
                              ->where('status', '=', 'active')
                              ->where('type', 'feature')
                              ->take(8);
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == "shop-list-items-latest") {
            $query      = $this->select('id', 'title', 'thumb', 'created')
                              ->where('status', '=', 'active')
                              ->orderBy('id', 'desc')
                              ->take(3);
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == "shop-list-items") {
            $query      = $this->select('a.id', 'a.title', 'c.name as category', 'a.category_id', 'a.content', 'a.tag', 'a.thumb', 'a.created')
                                ->leftJoin('blog_category as c', 'category_id', '=', 'c.id')
                                ->where('a.status', '=', 'active')
                                ->orderBy('a.id', 'asc')
                                ->take(6);
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == 'shop-list-items-in-category') {
            $query      = $this->select('id', 'title', 'content', 'thumb', 'tag', 'created')         
                                ->where('status', '=', 'active')
                                ->where('category_id', '=', $arrParam['category_id']);
            $result     = $query->get()->toArray(); 
        }

        if ($option['task'] == "shop-list-items-related") {
            $query = self::select('id', 'title', 'content', 'thumb', 'created')
                            ->where('status', '=', 'active')
                            ->where('id', '!=', $arrParam['id'])
                            ->where('category_id', '=', $arrParam['category_id'])
                            ->take(3);
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
            $result = self::select('id', 'title', 'content', 'thumb', 'status', 'tag')->where('id', $arrParam['id'])->first();
        }

        if ($option['task'] == 'get-thumb') {
            $result = self::select('id', 'thumb')->where('id', $arrParam['id'])->first();
        }

        
        if ($option['task'] == 'shop-get-items') {
            $result = self::select('a.id', 'a.category_id', 'a.title', 'a.content', 'a.thumb', 'a.tag', 'c.name as category', 'u.fullname as fullname', 'u.avatar as avatar', 'a.created', 'a.created_by')
                            ->leftJoin('blog_category as c', 'a.category_id', '=', 'c.id')
                            ->join('user as u', 'a.created_by', '=', 'u.username')
                            ->where('a.id', $arrParam['article_id'])
                            ->where('a.status', '=', 'active')->first();
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
            self::where('id', $arrParam['id'])
                ->update(['status' => $status]);
            $result = [
                'id'        => $arrParam["id"],
            ];
        }

        if ($option['task'] == "add-items") {
            $arrParam['time']           = date('Y-m-d H:i:s');
            $arrParam['ip_address']     = \Request::ip();
            $arrParam['status']         = 'active';
            self::insert($this->prepareParams($arrParam));
        }
        return $result;
    }

    public function deleteItems($arrParam = null, $option = null) {
        if ($option['task'] == "delete-item") {
            self::where('id', $arrParam['id'])->delete();
        }
    }
}

