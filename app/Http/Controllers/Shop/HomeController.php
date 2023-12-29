<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\BannerModel;
use App\Models\CategoryProductModel;
use App\Models\ProductModel;
use App\Models\ArticleModel;
 
class HomeController extends Controller {
    private $pathViewController     = 'shop.page.home.';
    private $controllerName         = 'home';
    private $arrParam               = [];
    private $model;

    public function __construct() {
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        $bannerModel            = new BannerModel();
        $categoryModel          = new CategoryProductModel();
        $productModel           = new ProductModel();
        $articleModel           = new ArticleModel();

        $itemSlider             = $productModel->listItems(null, ['task' => 'shop-list-items-slider']);
        $itemBanner             = $bannerModel->listItems(null, ['task' => 'shop-list-items-banner']);
        $itemCategory           = $categoryModel->listItems(null, ['task' => 'shop-list-items']);
        $itemFeature            = $productModel->listItems(null, ['task' => 'shop-list-items-feature']);
        $itemLatest             = $productModel->listItems(null, ['task' => 'shop-list-items-latest']);
        $itemBlog               = $articleModel->listItems(null, ['task' => 'shop-list-items-blog']);

        // foreach ($itemCategory as $key => $value) {
        //     $itemCategory[$key]['article'] = $productModel->listItems(['category_id' => $value['id']], ['task' => 'news-list-items-in-category']);
        // };

        return view($this->pathViewController . 'index', [
            // 'arrParam'      => $this->arrParam,
            'itemSlider'    => $itemSlider,
            'itemBanner'    => $itemBanner,
            'itemCategory'  => $itemCategory,
            'itemFeature'   => $itemFeature,
            'itemLatest'    => $itemLatest,
            'itemBlog'      => $itemBlog,
        ]);
    }

    public function getphone(Request $request) {
        echo '<pre style="color: red;">';
        print_r($this->arrParam);
        echo '</pre>';
        die('Function is called');
    }

    // public function error() {
    //     return view($this->pathViewController . '404');
    // }
}