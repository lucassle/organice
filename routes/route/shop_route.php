<?php
namespace App\Http\Controllers;

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
$prefixFrontend     = config('return.prefix.frontend');
Route::group(['prefix' => $prefixFrontend, 'namespace' => 'Shop'], function () {
    // ============================= HOME =============================
    $prefix                 = '';
    $controllerName         = 'home';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                                         ['as' => $controllerName,               'uses' => $controller . 'index']);
        Route::post('/getphone',                                ['as' => $controllerName . '/getphone', 'uses' => $controller . 'getphone']);
        // Route::get('/error',                                    ['as' => $controllerName . '/error',    'uses' => $controller . 'error']);
    });

    // ============================= CATEGORY =============================
    $prefix                 = 'store';
    $controllerName         = 'store';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                                    ['as' => "$controllerName",       'uses' => $controller . 'index']);
        Route::get('/{category_name}-{category_id}.html',  ['as' => "$controllerName/show-category", 'uses' => $controller . 'showCategory'])
                ->where('category_name', '[0-9a-zA-Z_-]+')
                ->where('category_id',   '[0-9]+');
    });

    // ============================= RSS =============================
    $prefix                 = 'blog';
    $controllerName         = 'blog';
    Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName)  . 'Controller@';
        Route::get('/',                                 ['as' => "$controllerName",         'uses' => $controller . 'index' ]);
        Route::get('/{blog_name}-{blog_id}.html',       ['as' => "$controllerName/show-category",   'uses' => $controller . 'showCategory'])
                ->where('blog_name', '[0-9a-zA-Z_-]+')
                ->where('blog_id',   '[0-9]+');
    });

    // ============================= PRODUCTS =============================
    $prefix                 = 'product';
    $controllerName         = 'product';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/{product_name}-{product_id}.html',     ['as' => "$controllerName/index", 'uses' => $controller . 'index'])
                ->where('product_name', '[0-9a-zA-Z_-]+')
                ->where('product_id',   '[0-9]+');
    });

    
    // ============================= ARTICLE =============================
    $prefix                 = 'article';
    $controllerName         = 'article';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/{article_name}-{article_id}.html',         ['as' => "$controllerName/index", 'uses' => $controller . 'index'])
                ->where('article_name', '[0-9a-zA-Z_-]+')
                ->where('article_id',   '[0-9]+');
    });

    // ============================= CONTACT =============================
    $prefix                 = 'contact';
    $controllerName         = 'contact';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                 ['as' => "$controllerName/index",        'uses' => $controller . 'index']);
        Route::post('/post-contact',    ['as' => "$controllerName/post_contact", 'uses' => $controller . 'postContact']);
    });

    // ============================= RECALL =============================
    $prefix                 = 'recall';
    $controllerName         = 'recall';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                 ['as' => "$controllerName/index",       'uses' => $controller . 'index']);
        Route::post('/get-phone',       ['as' => "$controllerName/getPhone",   'uses' => $controller . 'getPhone']);
    });

    // ============================= CART =============================
    $prefix                 = 'cart';
    $controllerName         = 'cart';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                 ['as' => "$controllerName",         'uses' => $controller . 'index']);
        Route::get('/remove/{rowId}',   ['as' => "$controllerName/remove",  'uses' => $controller . 'remove'])->where('rowId', '[0-9]+');
        // Route::post('/add-to-cart',     ['as' => "$controllerName/addItem", 'uses' => $controller . 'addItem']);
        Route::post('/add-to-cart',     ['as' => "$controllerName/addItemToCart", 'uses' => $controller . 'addItemToCart']);
        Route::delete('/delete/{id}',   ['as' => "$controllerName/remove", 'uses' => $controller . 'remove']);
        Route::post('/discount',        ['as' => "$controllerName/discount",'uses' => $controller . 'discount']);
    });

    // ============================= CHECKOUT =============================
    $prefix                 = 'checkout';
    $controllerName         = 'checkout';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                     ['as' => "$controllerName",             'uses' => $controller . 'index']);
        Route::post('/checkout',            ['as' => "$controllerName/checkout",    'uses' => $controller . 'checkout']);
        Route::get('/thanks-for-shopping',  ['as' => "$controllerName/redirect",    'uses' => $controller . 'redirect']);
    });

    // ============================= LOGIN =============================
    $prefix                 = '';
    $controllerName         = 'auth';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/login',                                    ['as' => $controllerName . '/login',    'uses' => $controller . 'login'])->middleware('check.login');
        Route::post('/postLogin',                               ['as' => $controllerName . '/postLogin','uses' => $controller . 'postLogin']);
        Route::get('/logout',                                   ['as' => $controllerName . '/logout',   'uses' => $controller . 'logout']);
    });

    // ============================= REGISTER =============================
    $prefix                 = 'register';
    $controllerName         = 'register';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                                 ['as' => $controllerName,                   'uses' => $controller . 'register']);
        Route::get('/redirect',                         ['as' => $controllerName . '/redirect',     'uses' => $controller . 'redirect']);
        Route::post('/postRegister',                    ['as' => $controllerName . '/postRegister', 'uses' => $controller . 'postRegister']);
    });

    // ============================= NOTIFY =============================
    $prefix                 = '';
    $controllerName         = 'notify';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/no-permission',                                    ['as' => $controllerName . '/noPermission',    'uses' => $controller . 'noPermission']);
    
    });
});
