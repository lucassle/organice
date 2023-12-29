<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
 
class CheckoutController extends Controller {
    private $pathViewController     = 'shop.page.checkout.';
    private $controllerName         = 'checkout';
    private $arrParam               = [];
    private $model;

    public function __construct() {  
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        return view($this->pathViewController . 'index', [
        ]);
    }

    // public function error() {
    //     return view($this->pathViewController . '404');
    // }
}