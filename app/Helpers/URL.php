<?php
namespace App\Helpers;
use Illuminate\Support\Str;

class URL {
    public static function linkCategoryProduct ($id, $name) {
        return route('store/show-category', ['category_id' => $id, 'category_name' => Str::slug($name)]);
    }

    public static function linkProduct ($id, $name) {
        return route('product/index', ['product_id' => $id, 'product_name' => Str::slug($name)]);
    }

    public static function linkCategoryArticle ($id, $name) {
        return route('blog/show-category', ['blog_id' => $id, 'blog_name' => Str::slug($name)]);
    }

    public static function linkArticle ($id, $name) {
        return route('article/index', ['article_id' => $id, 'article_name' => Str::slug($name)]);
    }

    public static function linkAddToCart ($id) {
        return route('cart/order', ['id' => $id]);
    }
}