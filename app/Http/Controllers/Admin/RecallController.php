<?php
 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\RecallModel as MainModel;
// use App\Http\Requests\ProductRequest as MainRequest;

class RecallController extends AdminController {
    
    public function __construct() {
        parent::__construct();
        $this->pathViewController       = 'admin.page.recall.';
        $this->controllerName           = 'recall';
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

    public function status(Request $request) {
        $arrParam["id"]     = $request->id;
        $arrParam["status"] = $request->status;
        $this->model->saveItems($arrParam, ['task' => 'change-status']);
        $status             = $request->status == "waiting" ? "contacted" : "waiting";
        $link               = route($this->controllerName . '/status', ['status' => $status, 'id' => $request->id]);
        return response()->json([
            'statusObj' => config('return.template.status')[$status],
            'link'      => $link,
            'message'   => config('return.notify.success.update')
        ]);
    }

}