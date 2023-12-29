<?php
 
namespace App\Http\Controllers\Admin;
 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel as MainModel;
use App\Http\Requests\UserRequest as MainRequest;

 
class UserController extends AdminController {
    protected $pathViewController     = 'admin.page.user.';
    protected $controllerName         = 'user';
    protected $arrParam               = [];
    protected $model;

    public function __construct() {
        // View::share('controllerName', $this->controllerName);
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

        return view($this->pathViewController . 'form', [
            'items'         => $items,
        ]);
    }

    public function level(Request $request) {
        $arrParam["level"]     = $request->route('level');
        $arrParam["id"]         = $request->route('id');
        $this->model->saveItems($arrParam, ['task' => 'change-level']);
        return response()->json([
            'message'   => config('return.notify.success.update')
        ]);
    }

    public function changePassword(MainRequest $request) {
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $this->model->saveItems($arrParam, ['task' => 'change-password']);
            return redirect()->route($this->controllerName)->with('zvn_notify', 'Updated successful!');
        }
    }

    public function changeLevelPost(MainRequest $request) {
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $this->model->saveItems($arrParam, ['task' => 'change-level-post']);
            return redirect()->route($this->controllerName)->with('zvn_notify', 'Updated successful!');
        }
    }

    public function save(MainRequest $request) {
        // $validation     = $request->validate();
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $task       = 'add-item';
            $notify     = 'Successful!';
            if ($arrParam['id'] !== null) {
                $task       = 'edit-info';
                $notify     = 'Updated successful!';
            }
            $this->model->saveItems($arrParam, ['task' => $task]);
            return redirect()->route($this->controllerName)->with('status_notify', $notify);
        }
    }
}