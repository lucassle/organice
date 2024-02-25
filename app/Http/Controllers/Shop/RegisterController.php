<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest as MainRequest;
use App\Models\UserModel;
use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Http\Request;
 
class RegisterController extends Controller {
    private $pathViewController     = 'shop.page.register.';
    private $controllerName         = 'register';
    private $arrParam               = [];
    private $model;

    public function __construct() {
        view()->share('controllerName', $this->controllerName);
    }

    public function register(Request $request) {
        if ((strpos(url()->previous(), $request->url()) === false)) session(['url.intended' => url()->previous()]);
        return view($this->pathViewController . 'register');
    }

    public function redirect(Request $request) {
        return view($this->pathViewController . 'redirect');
    }

    public function postRegister(MainRequest $request) {
        if ($request->method() == "POST") {
            $arrParam   = $request->all();
            $userModel  = new UserModel();

            $userModel->saveItems($arrParam, ['task' => 'add-new-user']);
            return redirect()->route('register/redirect')->with('status_notify', 'sign in successful!');
        }
    }
}