<?php

namespace App\Http\Controllers\Shop;

use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\CartModel;

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

    public function checkout(Request $request) {
        $arrParam   = $request->all();
        $arrParam['total_price']    = Cart::total();
        $arrParam['product']        = '';
        foreach (Cart::content()->toArray() as $value) {
            $product    = $value['name'];
            $qty        = $value['qty'];
            $arrParam['product']   .= $product . '*' . $qty;
        };
        $cartModel     = new CartModel();
        $cartModel->saveItems($arrParam, ['task' => 'add-items']);
        return redirect()->route($this->controllerName . '/redirect');
    }

    public function redirect(Request $request) {
        return view($this->pathViewController . 'redirect', [
        ]);
    }

    // public function error() {
    //     return view($this->pathViewController . '404');
    // }
}