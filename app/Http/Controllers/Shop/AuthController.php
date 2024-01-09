<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest as MainRequest;
use App\Models\UserModel;
use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Http\Request;
 
class AuthController extends Controller {
    private $pathViewController     = 'shop.page.auth.';
    private $controllerName         = 'auth';
    private $arrParam               = [];
    private $model;

    public function __construct() {
        view()->share('controllerName', $this->controllerName);
    }

    public function login(Request $request) {
        if ((strpos(url()->previous(), $request->url()) === false)) session(['url.intended' => url()->previous()]);
        return view($this->pathViewController . 'login');
    }

    public function postLogin(MainRequest $request) {
        if ($request->method() == "POST") {
            $arrParam   = $request->all();
            $userModel  = new UserModel();

            $userInfo   = $userModel->getItems($arrParam, ['task' => 'auth-login']);
            if (!$userInfo) {
                return redirect()->route($this->controllerName . '/login')->with('login_notify', 'Tài khoản hoặc Mật khẩu không chính xác!');
            }
            $request->session()->put('userInfo', $userInfo);
            $url    = session()->pull('url.intended');
            return redirect()->away($url);
        }
    }

    public function logout(Request $request) {
        Cart::destroy();
        if ($request->session()->has('userInfo')) $request->session()->pull('userInfo');
        return redirect()->route('home');
    }

}