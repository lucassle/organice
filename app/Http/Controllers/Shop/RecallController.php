<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\RecallModel;
use App\Http\Requests\RecallRequest as MainRequest;
 
class RecallController extends Controller {
    private $pathViewController     = 'shop.page.recall.';
    private $controllerName         = 'recall';
    private $arrParam               = [];
    private $model;

    public function __construct() {
        view()->share('controllerName', $this->controllerName);
    }

    public function index(MainRequest $request) {
        $recallModel                    = new RecallModel();
        
        return view($this->pathViewController . 'index', [
            // 'itemDetail'        => $itemDetail,
            // 'itemRelated'       => $itemRelated,
        ]);
    }
}