<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ArticleModel;
use App\Models\CategoryArticleModel;
 
class BlogController extends Controller {
    private $pathViewController     = 'shop.page.blog.';
    private $controllerName         = 'blog';
    private $arrParam               = [];
    private $model;

    public function __construct() {  
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        $articleModel       = new ArticleModel();
        $categoryModel      = new CategoryArticleModel();
        // $bannerModel            = new BannerModel();

        $itemBlog       = $articleModel->listItems(null, ['task' => 'shop-list-items']);
        $itemLatest     = $articleModel->listItems(null, ['task' => 'shop-list-items-latest']);
        $itemCategory   = $categoryModel->listItems(null, ['task' => 'shop-list-items']);
        $itemInCategory             = '';
        if (isset($arrParam['category_id'])) {
            $itemInCategory             = $categoryModel->getItems($arrParam, ['task' => 'shop-list-items-in-category']);
            $itemInCategory['article']  = $articleModel->listItems(['category_id' => $itemInCategory['id']], ['task' => 'shop-list-items-in-category']);
        }

        // foreach ($itemCategory as $key => $value) {
        //     $itemCategory[$key]['article'] = $articleModel->listItems(['category_id' => $value['id']], ['task' => 'news-list-items-in-category']);
        // };

        return view($this->pathViewController . 'index', [
            'arrParam'      => $this->arrParam,
            'itemBlog'      => $itemBlog,
            'itemCategory'  => $itemCategory,
            'itemInCategory'=> $itemInCategory,
            'itemLatest'    => $itemLatest,
            // 'itemFeature'   => $itemFeature,
        ]);
    }

    public function showCategory(Request $request) {
        $arrParam['blog_id']            = $request->blog_id;
        $articleModel       = new ArticleModel();
        $categoryModel      = new CategoryArticleModel();

        $itemBlog           = $articleModel->listItems(null, ['task' => 'shop-list-items']);
        $itemCategory               = $categoryModel->listItems(null, ['task' => 'shop-list-items']);
        $itemInCategory             = '';
        if (isset($arrParam['blog_id'])) {
            $itemInCategory             = $categoryModel->getItems($arrParam, ['task' => 'shop-list-items-in-category']);
            $itemInCategory['article']  = $articleModel->listItems(['category_id' => $itemInCategory['id']], ['task' => 'shop-list-items-in-category']);
        }
        $itemRecent                 = $articleModel->listItems(null, ['task' => 'shop-list-items-latest']);
        return view($this->pathViewController . 'article-in-category', [
            'arrParam'          => $this->arrParam,
            'itemBlog'          => $itemBlog,
            'itemCategory'      => $itemCategory,
            'itemRecent'        => $itemRecent,
            'itemInCategory'    => $itemInCategory,
        ]);
    }

    // public function error() {
    //     return view($this->pathViewController . '404');
    // }
}