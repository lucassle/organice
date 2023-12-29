<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\CategoryArticleModel;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;

class ArticleModel extends AdminModel {
    // use HasFactory;
    public function __construct() {
        $this->table                = 'article as a';
        $this->folderUpload         = 'article';
        $this->fieldSearchAccepted  = ['id', 'title', 'content', 'tag'];
        $this->crudNotAccepted      = ['_token', 'thumb_current'];
    }

    public function listItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == "admin-list-items") {
            $query     = $this->select('a.id', 'a.title', 'a.category_id', 'a.content', 'a.status', 'a.thumb', 'b.name as category')
                              ->leftJoin('category_article as b', 'a.category_id', '=', 'b.id');

            if ($arrParam['filter']['status'] !== "all") {
                $query->where('status', '=', $arrParam['filter']['status']);
            }

            if ($arrParam['filter']['category'] !== "all") {
                $categories     = CategoryArticleModel::descendantsAndSelf($arrParam['filter']['category'])->pluck('id')->toArray();
                $query->whereIN('a.category_id', $categories);
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
                              ->leftJoin('category_article as c', 'category_id', '=', 'c.id')
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
                                ->leftJoin('category_article as c', 'category_id', '=', 'c.id')
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
            $result = $this->select('id', 'title', 'content', 'thumb', 'status', 'category_id')
                           ->where('id', $arrParam['id'])->first();
        }

        if ($option['task'] == 'get-thumb') {
            $result = self::select('id', 'thumb')->where('id', $arrParam['id'])->first();
        }

        
        if ($option['task'] == 'shop-get-items') {
            $result = self::select('a.id', 'a.category_id', 'a.title', 'a.content', 'a.thumb', 'a.tag', 'c.name as category', 'u.fullname as fullname', 'u.avatar as avatar', 'a.created', 'a.created_by')
                            ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
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
            $modifiedBy = session("userInfo")["username"];
            $modified   = date('Y-m-d H:i:s');
            self::where('id', $arrParam['id'])
                ->update(['status' => $status, 'modified_by' => $modifiedBy, 'modified' => $modified]);
            $result = [
                'id'        => $arrParam["id"],
                'modified'  => Template::showItemHistory($modifiedBy, $modified),
            ];
        }

        if ($option['task'] == "change-category") {
            $modifiedBy = session("userInfo")["username"];
            $modified   = date('Y-m-d H:i:s');
            self::where('id', $arrParam['id'])->update($this->prepareParams($arrParam));

            $result = [
                'id'        => $arrParam["id"],
                'modified'  => Template::showItemHistory($modifiedBy, $modified),
                'message'   => config('return.notify.success.update')
            ];
        }

        if ($option['task'] == "add-item") {
            $arrParam['thumb']          = $this->uploadThumb($arrParam['thumb']);
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

