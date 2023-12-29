<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CategoryProductModel;
use App\Models\ProductModel;
 
class StoreController extends Controller {
    private $pathViewController     = 'shop.page.store.';
    private $controllerName         = 'store';
    private $arrParam               = [];
    private $model;

    public function __construct() {
        // $this->arrParam['pagination']['totalItemPerPage']   = 3;
        
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        $this->arrParam['filter']['sort']   = $request->input('sort', 'default');
        $arrParam['category_id']            = $request->category_id;
        $categoryModel              = new CategoryProductModel();
        $productModel               = new ProductModel();

        $itemCategory               = $categoryModel->listItems(null, ['task' => 'shop-list-items']);
        $itemSale                   = $productModel->listItems(null, ['task' => 'shop-list-items-sale-off']);
        $itemProduct                = $productModel->listItems(null, ['task' => 'shop-list-items']);
        $itemLatest                 = $productModel->listItems(null, ['task' => 'shop-list-items-latest']);
        return view($this->pathViewController . 'index', [
            'arrParam'          => $this->arrParam,
            'itemCategory'      => $itemCategory,
            'itemSale'          => $itemSale,
            'itemProduct'       => $itemProduct,
            'itemLatest'        => $itemLatest,
        ]);
    }

    public function showCategory(Request $request) {
        $this->arrParam['filter']['sort']   = $request->input('sort', 'default');
        $arrParam['category_id']            = $request->category_id;
        $categoryModel              = new CategoryProductModel();
        $productModel               = new ProductModel();

        $itemCategory               = $categoryModel->listItems(null, ['task' => 'shop-list-items']);
        $itemInCategory             = '';
        if (isset($arrParam['category_id'])) {
            $itemInCategory             = $categoryModel->getItems($arrParam, ['task' => 'shop-list-items-in-category']);
            $itemInCategory['product']  = $productModel->listItems(['category_id' => $itemInCategory['id']], ['task' => 'shop-list-items-in-category']);
        }
        $itemLatest                 = $productModel->listItems(null, ['task' => 'shop-list-items-latest']);
        return view($this->pathViewController . 'item-in-category', [
            'arrParam'          => $this->arrParam,
            'itemCategory'      => $itemCategory,
            'itemLatest'        => $itemLatest,
            'itemInCategory'    => $itemInCategory,
        ]);
    }

    // public function error() {
    //     return view($this->pathViewController . '404');
    // }
}