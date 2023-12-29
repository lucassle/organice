<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ArticleModel;
use App\Models\CategoryArticleModel;
 
class ArticleController extends Controller {
    private $pathViewController     = 'shop.page.article.';
    private $controllerName         = 'article';
    private $arrParam               = [];
    private $model;

    public function __construct() {  
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        $arrParam['article_id'] = $request->article_id;
        $articleModel           = new ArticleModel();
        $categoryModel          = new CategoryArticleModel();

        $itemArticle                    = $articleModel->getItems($arrParam, ['task' => 'shop-get-items']);
        if (empty($itemArticle)) return redirect()->route('blog');
        $itemRecent                     = $articleModel->listItems(null, ['task' => 'shop-list-items-latest']);
        $itemCategory                   = $categoryModel->listItems(null, ['task' => 'shop-list-items']);
        $itemArticle['related_item']    = $articleModel->listItems($itemArticle, ['task' => 'shop-list-items-related']);
        // foreach ($itemCategory as $key => $value) {
        //     $itemCategory[$key]['article'] = $articleModel->listItems(['category_id' => $value['id']], ['task' => 'news-list-items-in-category']);
        // };

        return view($this->pathViewController . 'index', [
            'arrParam'      => $this->arrParam,
            'itemArticle'   => $itemArticle,
            'itemCategory'  => $itemCategory,
            'itemRecent'    => $itemRecent,
            // 'itemFeature'   => $itemFeature,
        ]);
    }

    // public function error() {
    //     return view($this->pathViewController . '404');
    // }
}