<?php
 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SettingModel as MainModel;
 
class SettingController extends AdminController {
    protected $pathViewController     = 'admin.page.setting.';
    protected $controllerName         = 'setting';
    protected $arrParam               = [];
    protected $model;

    public function __construct() {
        parent::__construct();
        $this->model                    = new MainModel();
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        $arrParam['type']   = $request->input('type', 'general');
        $items          = '';
        $itemAccount    = '';
        $itemBcc        = '';
        $items          = $this->model->getItems($arrParam, ['task' => null]);
        if (!empty($arrParam['type'])) {
            $items  = $this->model->getItems($arrParam, ['task' => $arrParam['type']]);
            if ($arrParam['type'] == 'email') {
                $itemAccount    = $this->model->getItems($arrParam, ['task' => 'email-account']);
                $itemBcc        = $this->model->getItems($arrParam, ['task' => 'email-bcc']);
            }
        }

        return view($this->pathViewController . 'index', [
            'items'         => $items,
            'itemAccount'   => $itemAccount,
            'itemBcc'       => $itemBcc,
        ]);
    }

    public function general(Request $request) {
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $this->model->saveItems($arrParam, ['task' => 'general']);
            return redirect()->route($this->controllerName, ['type' => 'general'])->with('status_notify', 'Successfully Updated!');
        }
    }

    public function emailAccount(Request $request) {
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $this->model->saveItems($arrParam, ['task' => 'email-account']);
            return redirect()->route($this->controllerName, ['type' => 'email'])->with('status_notify', 'Updated successful!');
        }
    }

    public function emailBcc(Request $request) {
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $this->model->saveItems($arrParam, ['task' => 'email-bcc']);
            return redirect()->route($this->controllerName, ['type' => 'email'])->with('status_notify', 'Updated successful!');
        }
    }

    public function social(Request $request) {
        if ($request->method() == 'POST') {
            $arrParam   = $request->all();
            $this->model->saveItems($arrParam, ['task' => 'social']);
            return redirect()->route($this->controllerName, ['type' => 'social'])->with('status_notify', 'Successfully Updated!');
        }
    }
}