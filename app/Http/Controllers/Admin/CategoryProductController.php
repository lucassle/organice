<?php
 
namespace App\Http\Controllers\Admin;
 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryProductModel as MainModel;
use App\Http\Requests\CategoryProductRequest as MainRequest;

 
class CategoryProductController extends AdminController {

    protected $pathViewController     = 'admin.page.category_product.';
    protected $controllerName         = 'categoryProduct';
    protected $arrParam               = [];
    protected $model;

    public function __construct() {
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
            $items          = $this->model->getItems($arrParam, ['task' => 'get-items']);
        };
        $node   = $this->model->listItems($this->arrParam, ['task' => 'admin-list-items-in-select-box']);
        return view($this->pathViewController . 'form', compact('items', 'node'));
    }

    public function isHome(Request $request) {
        $arrParam["isHome"]     = $request->isHome;
        $arrParam["id"]         = $request->id;
        $this->model->saveItems($arrParam, ['task' => 'change-is-home']);
        $isHomeValue            = $request->isHome == "no" ? "yes" : "no";
        $link                   = route($this->controllerName . '/isHome', ['isHome' => $isHomeValue, 'id' => $request->id]);
        return response()->json([
            'isHomeObj' => config('return.template.is_home')[$isHomeValue],
            'link'      => $link,
            'message'   => config('return.notify.success.update')
        ]);
    }

    public function save(MainRequest $request) {
        // $validation     = $request->validate();
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $task       = 'add-item';
            $notify     = 'Successful!';
            if ($arrParam['id'] !== null) {
                $task       = 'edit-item';
                $notify     = 'Updated successful!';
            }
            $this->model->saveItems($arrParam, ['task' => $task]);
            return redirect()->route($this->controllerName)->with('status_notify', 'Updated successful!');
        }
    }

    public function ordering(Request $request) {
        $arrParam["type"]       = $request->type;
        $arrParam["id"]         = $request->id;
        $this->model->moveItems($arrParam, null);
        return redirect()->route($this->controllerName)->with('status_notify', 'Updated successful!');
    }
}