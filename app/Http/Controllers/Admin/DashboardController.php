<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use App\Models\CategoryProductModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\RecallModel;
use App\Models\ArticleModel;
use App\Models\ContactModel;
use App\Models\MenuModel;
use App\Models\CategoryArticleModel;
use App\Models\AttributeModel;
use App\Models\CouponModel;
use App\Models\ShippingCostModel;
use App\Models\OrderModel;
 
class DashboardController extends AdminController {
    protected $pathViewController     = 'admin.page.dashboard.';
    protected $controllerName         = 'dashboard';
    protected $arrParam               = [];
    protected $model;

    public function __construct() {
        view()->share('controllerName', $this->controllerName);
    }

    public function index() {
        $bannerModel            = new BannerModel();
        $categoryProductModel   = new CategoryProductModel();
        $productModel           = new ProductModel();
        $userModel              = new UserModel();
        $articleModel           = new ArticleModel();
        $recallModel            = new RecallModel();
        $contactModel           = new ContactModel();
        $menuModel              = new MenuModel();
        $categoryArticleModel   = new CategoryArticleModel();
        $attributeModel         = new AttributeModel();
        $couponModel            = new CouponModel();
        $shippingCostModel      = new ShippingCostModel();
        $orderModel             = new OrderModel();
        $totalBanner            = $bannerModel->countItems(null, ['task' => 'count-by-items']);
        $totalCategoryProduct   = $categoryProductModel->countItems(null, ['task' => 'count-by-items']);
        $totalProduct           = $productModel->countItems(null, ['task' => 'count-by-items']);
        $totalUser              = $userModel->countItems(null, ['task' => 'count-by-items']);
        $totalRecall            = $recallModel->countItems(null, ['task' => 'count-by-items']);
        $totalArticle           = $articleModel->countItems(null, ['task' => 'count-by-items']);
        $totalContact           = $contactModel->countItems(null, ['task' => 'count-by-items']);
        $totalMenu              = $menuModel->countItems(null, ['task' => 'count-by-items']);
        $totalCategoryArticle   = $categoryArticleModel->countItems(null, ['task' => 'count-by-items']);
        $totalAttribute         = $attributeModel->countItems(null, ['task' => 'count-by-items']);
        $totalCoupon            = $couponModel->countItems(null, ['task' => 'count-by-items']);
        $totalShippingCost      = $shippingCostModel->countItems(null, ['task' => 'count-by-items']);
        $totalOrder             = $orderModel->countItems(null, ['task' => 'count-by-items']);
        return view($this->pathViewController . 'index', [
            'controllerName'        => $this->controllerName,
            'totalBanner'           => $totalBanner,
            'totalCategoryProduct'  => $totalCategoryProduct,
            'totalProduct'          => $totalProduct,
            'totalUser'             => $totalUser,
            'totalArticle'          => $totalArticle,
            'totalRecall'           => $totalRecall,
            'totalContact'          => $totalContact,
            'totalMenu'             => $totalMenu,
            'totalCategoryArticle'  => $totalCategoryArticle,
            'totalAttribute'        => $totalAttribute,
            'totalCoupon'           => $totalCoupon,
            'totalShippingCost'     => $totalShippingCost,
            'totalOrder'            => $totalOrder,
        ]);

    }
}