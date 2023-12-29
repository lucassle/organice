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

    // ============================= ARTICLE =============================
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

    // ============================= CART =============================
    $prefix                 = 'cart';
    $controllerName         = 'cart';
    Route::group(['prefix' => $prefix, 'middleware' => ['permission.admin']], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                 ['as' => "$controllerName",         'uses' => $controller . 'index']);
        Route::post('/add-to-cart/{id}',     ['as' => "$controllerName/order",   'uses' => $controller . 'order'])->where('id', '[0-9]+');
        Route::post('/discount',        ['as' => "$controllerName/discount",   'uses' => $controller . 'discount']);
    });

    // ============================= CHECKOUT =============================
    $prefix                 = 'checkout';
    $controllerName         = 'checkout';
    Route::group(['prefix' => $prefix, 'middleware' => ['permission.admin']], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                 ['as' => "$controllerName",         'uses' => $controller . 'index']);
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

    // ============================= NOTIFY =============================
    $prefix                 = '';
    $controllerName         = 'notify';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/no-permission',                                    ['as' => $controllerName . '/noPermission',    'uses' => $controller . 'noPermission']);
    
    });
});
