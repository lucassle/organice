<?php
 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 
class AdminController extends Controller {
    protected $pathViewController     = '';
    protected $controllerName         = '';
    protected $arrParam               = [];
    protected $model;
    protected $request;

    public function __construct() {
        $this->arrParam['pagination']['totalItemPerPage']   = 5;
        view()->share('controllerName', $this->controllerName);
    }

    public function status(Request $request) {
        $arrParam["id"]     = $request->id;
        $arrParam["status"] = $request->status;
        $this->model->saveItems($arrParam, ['task' => 'change-status']);
        $status             = $request->status == "active" ? "inactive" : "active";
        $link               = route($this->controllerName . '/status', ['status' => $status, 'id' => $request->id]);
        return response()->json([
            'statusObj' => config('return.template.status')[$status],
            'link'      => $link,
            'message'   => config('return.notify.success.update')
        ]);
    }

    public function delete(Request $request) {
        $arrParam["id"]         = $request->route('id');
        $this->model->deleteItems($arrParam, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('status_notify', 'Deleted successful!');
    }
}