<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProductModel;

class NotifyController extends Controller
{
    private $pathViewController = 'shop.page.notify.';  // slider
    private $controllerName     = 'notify';
    private $params             = [];
    private $model;

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function noPermission(Request $request)
    {
        $categoryModel          = new CategoryProductModel();
        $itemCategory           = $categoryModel->listItems(null, ['task' => 'shop-list-items']);
        return view($this->pathViewController .  'no-permission', [
            'itemCategory'  => $itemCategory,
        ]);
    }

}