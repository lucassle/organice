<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ProductModel;
 
class ProductController extends Controller {
    private $pathViewController     = 'shop.page.product.';
    private $controllerName         = 'product';
    private $arrParam               = [];
    private $model;

    public function __construct() {
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        $arrParam['product_id']         = $request->product_id;
        $productModel                   = new ProductModel();

        $itemDetail                     = $productModel->getItems($arrParam, ['task' => 'shop-get-items']);
        if (empty($itemDetail)) return redirect()->route('store');
        $itemDetail['related_item']     = $productModel->listItems($itemDetail, ['task' => 'shop-list-items-related']);
        return view($this->pathViewController . 'index', [
            'arrParam'          => $this->arrParam,
            'itemDetail'        => $itemDetail,
            // 'itemRelated'       => $itemRelated,
        ]);
    }


}