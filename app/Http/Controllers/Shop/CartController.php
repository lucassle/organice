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
    public function addItem(Request $request) {
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
        Cart::add($request->input('product_id'),
                  $product['name'],
                  $request->input('quantity', 1),
                  $product['price'],
                  ['thumb' => $product['thumb']]);

        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {   
        $arrParam   = $request->all();
        // $id = $request->id();
        // Cart::remove($id);
        // session()->flash('success_notify', 'Item has been removed!');
        // return redirect()->route('cart')->with('success_notify', 'Item has been removed');
    }

}