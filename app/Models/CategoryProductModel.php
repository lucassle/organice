<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;
use Kalnoy\Nestedset\NodeTrait;

class CategoryProductModel extends AdminModel {
    // use HasFactory;
    use NodeTrait;

    protected $table    = 'category_product';
    protected $guarded  = [];

    public function listItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == "admin-list-items") {
            // $query     = $this->select('id', 'name', 'is_home', 'status', 'created', 'created_by', 'modified', 'modified_by');
            // if ($arrParam['filter']['status'] !== "all") {
            //     $query->where('status', '=', $arrParam['filter']['status']);
            // }

            // if ($arrParam['search']['value'] !== "") {
            //     if ($arrParam['search']['field'] == "all") {
            //         $query->where(function($query) use ($arrParam) {
            //             foreach ($this->fieldSearchAccepted as $value) {
            //                 $query->orWhere($value, "LIKE", "%{$arrParam['search']['value']}%");
            //             }
            //         });
            //     } else if (in_array($arrParam['search']['field'], $this->fieldSearchAccepted)) {
            //         $query->where($arrParam['search']['field'], "LIKE", "%{$arrParam['search']['value']}%");
            //     }
            // }
            // $result     = $query->get();
            $query = self::withDepth()
                      ->having('depth', '>', 0)
                      ->defaultOrder()
                      ->get();
                      
            $result = $query->toFlatTree();
        }

        if ($option['task'] == "admin-list-items-in-select-box") {
            $query      = self::select('id', 'name')->withDepth()->defaultOrder();

            if (isset($arrParam['id'])) {
                $node  = self::find($arrParam['id']);
                $query->where('_lft', '<', $node->_lft)->orWhere('_lft', '>', $node->_rgt);
            }
            $node      = $query->get()->toFlatTree();
            foreach ($node as $value) {
                $result[$value['id']]   = str_repeat('|---- ', $value['depth']) . $value['name'];
            }
        }
        
        if ($option['task'] == "shop-list-items") {
            $query      = $this->select('id', 'name')
                                ->where('status', '=', 'active');
            $result     = $query->get()->toArray();
        }

        if ($option['task'] == "list-category-in-select-box") {
            $query      = $this->select('id', 'name')
                                ->orderBy('name', 'asc')
                                ->where('status', '=', 'active');
            $result     = $query->pluck('name', 'id')->toArray();
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
            $query     = self::select(DB::raw('count(id) - 1 as count'));
            $result = $query->get()->toArray();
        }
        return $result;
    }

    public function getItems($arrParam = null, $option = null) {
        $result     = null;
        if ($option['task'] == 'get-items') {
            $result = self::select('id', 'name', 'parent_id', 'status', 'is_home')->where('id', $arrParam['id'])->first();
        }

        if ($option['task'] == 'shop-list-items-in-category') {
            $query = self::select('id', 'name')->where('id', $arrParam['category_id'])->first();
            if($query){
                $result = $query->toArray();
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

        if ($option['task'] == "change-is-home") {
            $isHome = ($arrParam['isHome'] == 'yes') ? 'no' : 'yes';
            $modifiedBy = session("userInfo")["username"];
            $modified   = date('Y-m-d H:i:s');
            self::where('id', $arrParam['id'])
                ->update(['is_home' => $isHome, 'modified_by' => $modifiedBy, 'modified' => $modified]);
            $result = [
                'id'        => $arrParam["id"],
                'modified'  => Template::showItemHistory($modifiedBy, $modified),
            ];
        }

        if ($option['task'] == "change-display") {
            $display    = $arrParam['display'];
            $modifiedBy = session("userInfo")["username"];
            $modified   = date('Y-m-d H:i:s');
            self::where('id', $arrParam['id'])
                ->update(['display' => $display, 'modified_by' => $modifiedBy, 'modified' => $modified]);
            $result = [
                'id'        => $arrParam["id"],
                'modified'  => Template::showItemHistory($modifiedBy, $modified),
            ];
        }

        if ($option['task'] == "add-item") {
            $arrParam['created_by']     = session("userInfo")["username"];
            $arrParam['created']        = date('Y-m-d H:i:s');
            $parent                     = self::find($arrParam['parent_id']);
            self::create($this->prepareParams($arrParam), $parent);
        }

        if ($option['task'] == "edit-item") {
            $arrParam['modified_by']    = session("userInfo")["username"];
            $arrParam['modified']       = date('Y-m-d H:i:s');
            $parent                     = self::find($arrParam['parent_id']);
            $query = $current = self::find($arrParam['id']);
            $query->update($this->prepareParams($arrParam));
            if ($current->parent_id != $arrParam['parent_id']) $result = $query->prependToNote($parent)->save();
        }
        return $result;
    }

    public function deleteItems($arrParam = null, $option = null) {
        if ($option['task'] == "delete-item") {
            $node  = self::find($arrParam['id']);
            $node->delete();
        }
    }

    public function moveItems($arrParam = null, $option = null) {
        $node          = self::find($arrParam['id']);
        $modifiedBy     = session('userInfo')['username'];
        $this->where('id', $arrParam['id'])->update(['modified_by' => $modifiedBy]);
        if ($arrParam['type'] == 'up') $node->up();
        if ($arrParam['type'] == 'down') $node->down();
    }
}
