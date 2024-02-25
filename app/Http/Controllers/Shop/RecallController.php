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

    public function index(Request $request) {
        
        return view($this->pathViewController . 'index', [
            // 'itemDetail'        => $itemDetail,
            // 'itemRelated'       => $itemRelated,
        ]);
    }

    public function getPhone(Request $request)
    {
        // Validate the request data
        $request->validate([
            'phoneNumber' => 'required|string',
        ]);

        // Create a new phone number instance
        $recallModel = new RecallModel();
        $recallModel->number = $request->phoneNumber;
        $recallModel->save();

        return response()->json(['message' => 'Phone number inserted successfully']);
    }
}