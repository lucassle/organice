<?php
 
namespace App\Http\Controllers\Admin;
 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\AttributeModel as MainModel;
use App\Http\Requests\AttributeRequest as MainRequest;

 
class AttributeController extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->pathViewController       = 'admin.page.attribute.';
        $this->controllerName           = 'attribute';
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

        return view($this->pathViewController . 'form', ['items' => $items]);
    }

    public function ordering(Request $request) {
        $arrParam["id"]         = $request->id;
        $arrParam["ordering"]   = $request->ordering;
        $result                 = $this->model->saveItems($arrParam, ['task' => 'change-ordering']);
        echo json_encode($result);
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
            return redirect()->route($this->controllerName)->with('status_notify', 'Updated successful!');
        }
    }
}