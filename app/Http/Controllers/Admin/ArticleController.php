<?php
 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\ArticleModel as MainModel;
use App\Models\CategoryArticleModel;
use App\Http\Requests\ArticleRequest as MainRequest;

class ArticleController extends AdminController {
    
    public function __construct() {
        parent::__construct();
        $this->pathViewController       = 'admin.page.article.';
        $this->controllerName           = 'article';
        $this->model                    = new MainModel();
        $this->arrParam['pagination']['totalItemPerPage']   = 5;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        $this->arrParam['filter']['status']     = $request->input('filter_status', 'all');
        $this->arrParam['search']['field']      = $request->input('search_field', 'all');
        $this->arrParam['filter']['category']   = $request->input('filter_category', 'all');
        $this->arrParam['search']['value']      = $request->input('search_value', '');

        $items              = $this->model->listItems($this->arrParam, ['task' => 'admin-list-items']);
        $countByStatus      = $this->model->countItems($this->arrParam, ['task' => 'admin-count-items']);

        return view($this->pathViewController . 'index', [
            'arrParam'      => $this->arrParam,
            'items'         => $items,
            'countByStatus' => $countByStatus,
        ]);
    }

    public function form(Request $request) {
        $items   = null;
        if ($request->id !== null) {
            $arrParam["id"] = $request->id;
            $items   = $this->model->getItems($arrParam, ['task' => 'get-items']);
        };
        $categoryModel  = new CategoryArticleModel();
        $node           = $categoryModel->listItems($this->arrParam, ['task' => 'admin-list-items-in-select-box']);

        return view($this->pathViewController . 'form', compact('items', 'node'));
    }

    public function save(MainRequest $request) {
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $task       = 'add-item';
            $notify     = 'Successful!';
            if ($arrParam['id'] !== null) {
                $task       = 'edit-item';
                $notify     = 'Updated successful!';
            }
            $this->model->saveItems($arrParam, ['task' => $task]);
            return redirect()->route($this->controllerName)->with('status_notify', $notify);
        }
    }

    public function category(Request $request) {
        $arrParam["id"]             = $request->id;
        $arrParam["category_id"]    = $request->category_id;
        $result                     = $this->model->saveItems($arrParam, ['task' => 'change-category']);
        return response()->json($result);
    }
}