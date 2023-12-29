<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CouponModel;
use Gloudemans\Shoppingcart\Facades\Cart;
use Str;
 
class CartController extends Controller {
    private $pathViewController     = 'shop.page.cart.';
    private $controllerName         = 'cart';
    private $arrParam               = [];
    private $model;

    public function __construct() {  
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        // $arrParam       = $request->all();
        $couponModel    = new CouponModel();
        $couponItems    = $couponModel->listItems(null, ['task' => 'shop-list-items']);
        return view($this->pathViewController . 'index', [
            'arrParam'          => $this->arrParam,
            'couponItems'       => $couponItems,
        ]);
    }
    public function order(Request $request) {
        // if ($request->method() == 'POST') {
        //     $arrParam       = $request->all();
        //     $id             = $request->id;
        //     $cart           = session()->get('cart');
        //     $productModel   = new ProductModel();
        //     // $productItems   = ProductModel::findOrFail($id);
        //     $productItems   = $productModel->getItems($arrParam, ['task' => 'get-items']);
        //     if (isset($cart[$id])) {
        //         $cart[$id]['quantity'] += 1;
        //         $cart[$id]['total']     = number_format($cart[$id]['quantity'] * $productItems->price, 2, '.', '');
        //     } else {
        //         $cart[$id]  = [
        //             'name'      => $productItems->name,
        //             'quantity'  => 1,
        //             'price'     => $productItems->price,
        //             'thumb'     => $productItems->thumb,
        //             'total'     => $productItems->price,
        //         ];
        //     }
        //     session()->put('cart', $cart);
        //     // session()->forget('cart');
        //     // session()->flush();
        //     return redirect()->route('store')->with('success_notify', 'Added to Cart!');
        // }
        $arrParam       = $request->all();
        $productModel   = new ProductModel();
        $product        = $productModel->getItems($arrParam, ['task' => 'shop-get-items']);
        // echo '<pre style="color: red;">';
        // print_r($product);
        // echo '</pre>';
        // die('Function is called');
        
        Cart::add($product['id'],
                  $product['name'],
                  $request->input('quantities'),
                  $product['price'],
                  ['thumb' => $product['thumb']]);

        return redirect()->route($this->controllerName)->with('success_notify', 'Successfully!');
    }

}