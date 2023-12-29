<?php
 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\MenuModel as MainModel;
use App\Http\Requests\MenuRequest as MainRequest;
// use App\Http\Requests\SliderRequest as MainRequest;

class MenuController extends AdminController {

    // protected $pathViewController     = 'admin.page.menu.';
    // protected $controllerName         = 'menu';
    // protected $arrParam               = [];
    // protected $model;

    public function __construct() {
        parent::__construct();
        $this->pathViewController       = 'admin.page.menu.';
        $this->controllerName           = 'menu';
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

    public function ordering(Request $request) {
        $arrParam["id"]         = $request->id;
        $arrParam["ordering"]   = $request->ordering;
        $result                 = $this->model->saveItems($arrParam, ['task' => 'change-ordering']);
        echo json_encode($result);
        // return redirect()->route($this->controllerName)->with('zvn_notify', 'Updated successful!');
    }

    public function typeMenu(Request $request) {
        $arrParam["id"]         = $request->id;
        $arrParam["type_menu"]  = $request->typeMenu;
        $this->model->saveItems($arrParam, ['task' => 'change-type-menu']);
        return response()->json([
            'message'       => config('return.notify.success.update')
        ]);
    }

    public function typeOpen(Request $request) {
        $arrParam["id"]         = $request->id;
        $arrParam["type_open"]  = $request->typeOpen;
        $this->model->saveItems($arrParam, ['task' => 'change-type-open']);
        return response()->json([
            'message'       => config('return.notify.success.update')
        ]);
    }

    public function form(Request $request) {
        $items   = null;
        if ($request->id !== null) {
            $arrParam["id"] = $request->id;
            $items   = $this->model->getItems($arrParam, ['task' => 'get-items']);
        };

        return view($this->pathViewController . 'form', ['items' => $items]);
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
}