<?php
 
namespace App\Http\Controllers\Admin;
 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\OrderModel as MainModel;
use App\Http\Requests\OrderRequest as MainRequest;

 
class OrderController extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->pathViewController       = 'admin.page.order.';
        $this->controllerName           = 'order';
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

    public function shipmentStatus (Request $request) {
        $arrParam["id"]         = $request->id;
        $arrParam["status"]     = $request->status;
        $this->model->saveItems($arrParam, ['task' => 'change-status']);
        return response()->json([
            'message'       => config('return.notify.success.update')
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
}