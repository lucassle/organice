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
$prefixAdmin    = config('return.prefix.backend');

Route::group(['prefix' => $prefixAdmin, 'namespace' => 'Admin', 'middleware' => ['permission.admin']], function () {
    // ============================= DASHBOARD =============================
    $prefix                 = '';
    $controllerName         = 'dashboard';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
    });

    // ============================= BANNER =============================
    $prefix                 = 'banner';
    $controllerName         = 'banner';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('form/{id?}',                    ['as' => $controllerName . '/form',         'uses' => $controller . 'form'])   ->where('id', '[0-9]+');
        Route::post('save',                         ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
        Route::get('change-status-{status}/{id}',   ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('change-ordering-{ordering}/{id}',   ['as' => $controllerName . '/ordering', 'uses' => $controller . 'ordering'])->where('id', '[0-9]+');
        Route::get('delete/{id}',                   ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
    });

    // ============================= CATEGORY =============================
    $prefix                 = 'category-product';
    $controllerName         = 'categoryProduct';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('form/{id?}',                    ['as' => $controllerName . '/form',         'uses' => $controller . 'form'])   ->where('id', '[0-9]+');
        Route::post('save',                         ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
        Route::get('change-status-{status}/{id}',   ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('delete/{id}',                   ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
        Route::get('change-is-home-{isHome}/{id}',  ['as' => $controllerName . '/isHome',       'uses' => $controller . 'isHome']) ->where('id', '[0-9]+');
        Route::get('ordering-{type}/{id}', $controller . 'ordering')->name("$controllerName/ordering")->where('id', '[0-9]+');
    });

    // // ============================= ARTICLE =============================
    $prefix                 = 'product';
    $controllerName         = 'product';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('form/{id?}',                    ['as' => $controllerName . '/form',         'uses' => $controller . 'form'])   ->where('id', '[0-9]+');
        Route::post('save',                         ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
        Route::post('change-category',              ['as' => $controllerName . '/changeCategory','uses' => $controller . 'changeCategory']);
        Route::post('change-seo',                   ['as' => $controllerName . '/changeSeo',    'uses' => $controller . 'changeSeo']);
        Route::get('change-status-{status}/{id}',   ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('delete/{id}',                   ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
        Route::get('change-type-{type}/{id}',       ['as' => $controllerName . '/type',         'uses' => $controller . 'type'])   ->where('id', '[0-9]+');
        Route::post('change-attribute',             ['as' => $controllerName . '/changeAttribute','uses' => $controller . 'changeAttribute']);
        Route::post('media',                         ['as' => $controllerName . '/media',        'uses' => $controller . 'media']);
    });

    // // ============================= USER =============================
    $prefix                 = 'user';
    $controllerName         = 'user';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('form/{id?}',                    ['as' => $controllerName . '/form',         'uses' => $controller . 'form'])   ->where('id', '[0-9]+');
        Route::post('save',                         ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
        Route::post('change-password',              ['as' => $controllerName . '/changePassword', 'uses' => $controller . 'changePassword']);
        Route::post('change-level-post',            ['as' => $controllerName . '/changeLevelPost', 'uses' => $controller . 'changeLevelPost']);
        Route::get('change-status-{status}/{id}',   ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('change-level-{level}/{id}',     ['as' => $controllerName . '/level',        'uses' => $controller . 'level']) ->where('id', '[0-9]+');
        Route::get('delete/{id}',                   ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
    });

    // // ============================= ARTICLE =============================
    $prefix                 = 'article';
    $controllerName         = 'article';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                                 ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('form/{id?}',                        ['as' => $controllerName . '/form',         'uses' => $controller . 'form'])   ->where('id', '[0-9]+');
        Route::post('save',                             ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
        Route::get('delete/{id}',                       ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
        Route::get('change-status-{status}/{id}',       ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('change-category-{category_id}/{id}',['as' => $controllerName . '/change-category','uses' => $controller . 'category']) ->where('id', '[0-9]+');
    });

    
    // // ============================= CATEGORY ARTICLE =============================
    $prefix                 = 'category-article';
    $controllerName         = 'categoryArticle';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                                 ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('form/{id?}',                        ['as' => $controllerName . '/form',         'uses' => $controller . 'form'])   ->where('id', '[0-9]+');
        Route::post('save',                             ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
        Route::get('change-status-{status}/{id}',       ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('delete/{id}',                       ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
        Route::get('change-is-home-{isHome}/{id}',      ['as' => $controllerName . '/isHome',       'uses' => $controller . 'isHome']) ->where('id', '[0-9]+');
        Route::get('ordering-{type}/{id}', $controller . 'ordering')->name("$controllerName/ordering")->where('id', '[0-9]+');
    });

    // // ============================= MENU =============================
    $prefix                 = 'menu';
    $controllerName         = 'menu';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                                 ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('form/{id?}',                        ['as' => $controllerName . '/form',         'uses' => $controller . 'form'])   ->where('id', '[0-9]+');
        Route::post('save',                             ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
        Route::get('change-status-{status}/{id}',       ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('delete/{id}',                       ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
        Route::get('chang-type-menu-{type_menu}/{id}',  ['as' => $controllerName . '/type_menu',     'uses' => $controller . 'typeMenu']) ->where('id', '[0-9]+');
        Route::get('change-type-open-{type_open}/{id}', ['as' => $controllerName . '/type_open',     'uses' => $controller . 'typeOpen'])->where('id', '[0-9]+');
        Route::get('change-ordering-{ordering}/{id}',   ['as' => $controllerName . '/ordering',     'uses' => $controller . 'ordering']) ->where('id', '[0-9]+');
    });

    // // ============================= PASSWORD =============================
    $prefix                 = 'password';
    $controllerName         = 'password';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => "$controllerName",                       'uses' => $controller . 'index']);
        Route::post('/change-password',             ['as' => "$controllerName/changePassword",      'uses' => $controller . 'changePassword']);
    });

    // ============================= RECALL =============================
    $prefix                 = 'recall';
    $controllerName         = 'recall';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('change-status-{status}/{id}',   ['as' => $controllerName . '/status', 'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('delete/{id}',                   ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
    });

    // ============================= CONTACT =============================
    $prefix                 = 'contact';
    $controllerName         = 'contact';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('change-status-{status}/{id}',   ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('delete/{id}',                   ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
    });

    // // ============================= SETTING =============================
    $prefix                 = 'setting';
    $controllerName         = 'setting';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => "$controllerName",                         'uses' => $controller . 'index']);
        Route::post('/general-setting',             ['as' => "$controllerName/general_setting",         'uses' => $controller . 'general']);
        Route::post('/social-setting',              ['as' => "$controllerName/social_setting",          'uses' => $controller . 'social']);
        Route::post('/email-account-setting',       ['as' => "$controllerName/email_account_setting",   'uses' => $controller . 'emailAccount']);
        Route::post('/email-bcc-setting',           ['as' => "$controllerName/email_bcc_setting",       'uses' => $controller . 'emailBcc']);
    });

    // ============================= ATTRIBUTE =============================
    $prefix                 = 'attribute';
    $controllerName         = 'attribute';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('form/{id?}',                    ['as' => $controllerName . '/form',         'uses' => $controller . 'form'])   ->where('id', '[0-9]+');
        Route::post('save',                         ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
        Route::get('change-status-{status}/{id}',   ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('change-ordering-{ordering}/{id}',['as' => $controllerName . '/ordering', 'uses' => $controller . 'ordering'])->where('id', '[0-9]+');
        Route::get('delete/{id}',                   ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
    });

    // ============================= COUPON =============================
    $prefix                 = 'coupon';
    $controllerName         = 'coupon';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('form/{id?}',                    ['as' => $controllerName . '/form',         'uses' => $controller . 'form'])   ->where('id', '[0-9]+');
        Route::post('save',                         ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
        Route::get('change-status-{status}/{id}',   ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('delete/{id}',                   ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
    });

    // ============================= SHIPPING COST =============================
    $prefix                 = 'shipping-cost';
    $controllerName         = 'shippingCost';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('form/{id?}',                    ['as' => $controllerName . '/form',         'uses' => $controller . 'form'])   ->where('id', '[0-9]+');
        Route::post('save',                         ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
        Route::get('change-status-{status}/{id}',   ['as' => $controllerName . '/status',       'uses' => $controller . 'status']) ->where('id', '[0-9]+');
        Route::get('delete/{id}',                   ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
    });

    // // ============================= GALLERY =============================
    $prefix                 = 'gallery';
    $controllerName         = 'gallery';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
    });

    // // ============================= GALLERY =============================
    $prefix                 = 'order';
    $controllerName         = 'order';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::get('change-status/{id}',   ['as' => $controllerName . '/shipmentStatus',       'uses' => $controller . 'shipmentStatus']) ->where('id', '[0-9]+');
        Route::get('delete/{id}',                   ['as' => $controllerName . '/delete',       'uses' => $controller . 'delete']) ->where('id', '[0-9]+');
    });

    // // ============================= GALLERY =============================
    $prefix                 = 'video';
    $controllerName         = 'video';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller         = ucfirst($controllerName) . 'Controller@';
        Route::get('/',                             ['as' => $controllerName,                   'uses' => $controller . 'index']);
        Route::post('save',                         ['as' => $controllerName . '/save',         'uses' => $controller . 'save']);
    });

    // // ============================= FILE MANAGER =============================
    // Route::group(['prefix' => 'laravel-filemanager'], function () {
    //     \UniSharp\LaravelFilemanager\Lfm::routes();
    // });

    // // ============================= LOG VIEWER =============================
    $prefix                 = 'logs';
    Route::group(['prefix' => $prefix], function () {
        Route::get('/', function () {
            return view('admin.page.logs.index');
        })->name('logs');
    });

});
