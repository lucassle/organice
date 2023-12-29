<?php
 
namespace App\Http\Controllers\Admin;
 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Http\Requests\PasswordRequest as MainRequest;
use Illuminate\Support\Facades\Hash;
 
class PasswordController extends AdminController {
    protected $pathViewController     = 'admin.page.password.';
    protected $controllerName         = 'password';
    protected $arrParam               = [];
    protected $model;

    public function __construct() {
        $this->model                    = new UserModel();
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        // $id = session('userInfo')['id'];
        return view($this->pathViewController . 'index');
    }

    public function changePassword(Request $request) {
        if ($request->method() == 'POST') {
            $arrParam               = $request->all();
            // $arrParam['id']         = session('userInfo')['id'];
            $password               = $this->model->getItems($arrParam['id'], ['task' => 'get-info']);
            $request->validate([
                'current_password'  => 'required',
                'new_password'      => 'required|confirmed',
            ]);
            // echo '<pre style="color: red;">';
            // print_r(md5($request->current_password));
            // echo '</pre>';
            // die('Function is called');
            if (md5($request->current_password) == $password['password']) {
                $this->model->saveItems($arrParam['id'], ['task' => 'change-password-info']);
                return redirect()->route($this->controllerName)->with('status_notify', 'Updated successful!');
            } else {
                return redirect()->route($this->controllerName)->with('status_notify', 'Warning!');
            }
        }
    }
}