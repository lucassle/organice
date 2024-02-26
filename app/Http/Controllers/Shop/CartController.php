<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CouponModel;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;
 
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
        $arrParam       = $request->all();
        $productModel   = new ProductModel();
        $product        = $productModel->getItems($arrParam, ['task' => 'cart-items']);
        Cart::add($arrParam['id'],
                  $product['name'],
                  1,
                  $product['price'],
                  ['thumb' => $product['thumb']]);

        return response()->json(['message', 'Item added to cart successfully!!!']);
        // return redirect()->route('store')->with('message', 'State saved correctly!!!');
    }

    public function addItemToCart(Request $request) {
        $arrParam       = $request->all();
        $productModel   = new ProductModel();
        $product        = $productModel->getItems($arrParam, ['task' => 'shop-get-items']);
        Cart::add($request->input('product_id'),
                  $product['name'],
                  $request->input('quantity', 1),
                  $product['price'],
                  ['thumb' => $product['thumb']]);

        // return response()->json();
        return redirect()->route('product/index', ['product_name' => Str::slug($product['name']), 'product_id' => $request->input('product_id')])->with('message', 'Item added to cart successfully!!!');
    }

    public function remove(Request $request) {   
        // $arrParam   = $request->all();
        $arrParam['rowId']  = $request->rowId;
        Cart::remove($arrParam['rowId']);
        return redirect()->route('cart')->with('message', 'Item removed from cart successfully');
    }

    public function discount(Request $request) {
        $discountCode = $request->input('discount_code');
        $code = CouponModel::where('code', $discountCode)->first();
        
        if ($code) {
            session()->put('discount_code', $discountCode);
            return redirect()->back()->with('success', 'Discount code applied successfully');
        } else {
            return redirect()->back()->with('error', 'Invalid discount code');
        }
    }

}