<?php
 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\ProductModel as MainModel;
use App\Models\CategoryProductModel;
use App\Models\AttributeModel;
use App\Http\Requests\ProductRequest as MainRequest;
use Attribute;

class ProductController extends AdminController {
    
    public function __construct() {
        parent::__construct();
        $this->pathViewController       = 'admin.page.product.';
        $this->controllerName           = 'product';
        $this->model                    = new MainModel();
        $this->arrParam['pagination']['totalItemPerPage']   = 5;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        $this->arrParam['filter']['status']  = $request->input('filter_status', 'all');
        $this->arrParam['search']['field']   = $request->input('search_field', 'all');
        $this->arrParam['search']['value']   = $request->input('search_value', '');

        $items              = $this->model->listItems($this->arrParam, ['task' => 'admin-list-items']);
        $countByStatus      = $this->model->countItems($this->arrParam, ['task' => 'admin-count-items']);

        return view($this->pathViewController . 'index', [
            'arrParam'      => $this->arrParam,
            'items'         => $items,
            'countByStatus' => $countByStatus
        ]);
    }

    public function form(Request $request) {
        $items   = null;
        if ($request->id !== null) {
            $arrParam["id"] = $request->id;
            $items   = $this->model->getItems($arrParam, ['task' => 'get-items']);
        };

        $categoryModel  = new CategoryProductModel();
        $attributeModel = new AttributeModel();
        $itemCategory   = $categoryModel->listItems($this->arrParam, ['task' => 'list-category-in-select-box']);
        $node           = $categoryModel->listItems($this->arrParam, ['task' => 'admin-list-items-in-select-box']);
        $itemAttribute  = $attributeModel->listItems($this->arrParam, ['task' => 'admin-list-items-for-product']);
        return view($this->pathViewController . 'form', [
            'items'             => $items,
            'itemCategory'      => $itemCategory,
            'node'              => $node,
            'itemAttribute'     => $itemAttribute,
        ]);
    }

    public function type(Request $request) {
        $arrParam["type"]       = $request->route('type');
        $arrParam["id"]         = $request->route('id');
        $this->model->saveItems($arrParam, ['task' => 'change-type']);
        $type                   = $request->type == "normal" ? "feature" : "normal";
        $link                   = route($this->controllerName . '/type', ['type' => $type, 'id' => $request->id]);
        return response()->json([
            'typeObj' => config('return.template.type')[$type],
            'link'      => $link,
            'message'   => config('return.notify.success.update')
        ]);
    }

    public function save(MainRequest $request) {
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $task       = 'add-item';
            $notify     = 'Successfully!';
            if ($arrParam['id'] !== null) {
                $task       = 'edit-item';
                $notify     = 'Successfully Updated!';
            }
            $this->model->saveItems($arrParam, ['task' => $task]);
            return redirect()->route($this->controllerName)->with('status_notify', $notify);
        }
    }

    public function changeCategory(MainRequest $request) {
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $this->model->saveItems($arrParam, ['task' => 'change-category']);
            return redirect()->route($this->controllerName)->with('status_notify', 'Successfully Updated!');
        }
    }

    public function changeAttribute(MainRequest $request) {
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $this->model->saveItems($arrParam, ['task' => 'change-attribute']);
            return redirect()->route($this->controllerName)->with('status_notify', 'Successfully Updated!');
        }
    }

    public function media(Request $request) {
        $path   = public_path('image/product');

        if (!file_exists($path)) mkdir($path, 0777, true);

        $file   = $request->file('file');
        $name   = $this->model->uploadThumb($file);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName()
        ]);
    }
}