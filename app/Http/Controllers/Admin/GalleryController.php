<?php
 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\View;
 
class GalleryController extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->pathViewController       = 'admin.page.gallery.';
        $this->controllerName           = 'gallery';
        $this->arrParam['pagination']['totalItemPerPage']   = 5;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        View::share('title', 'Gallery');

        return view($this->pathViewController . 'index');
    }
}