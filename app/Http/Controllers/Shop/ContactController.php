<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use App\Mail\MailService;
use App\Models\ContactModel;

use Illuminate\Http\Request;
 
class ContactController extends Controller {
    private $pathViewController     = 'shop.page.contact.';
    private $controllerName         = 'contact';
    private $arrParam               = [];
    private $model;

    public function __construct() {
        $this->model    = new ContactModel();
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request) {
        return view($this->pathViewController . 'index', [
            // 'arrParam'      => $this->arrParam,
        ]);
    }

    public function postContact(Request $request) {
        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'message'   => $request->message,
        ];
        
        $this->model->saveItems($data, ['task' => 'add-items']);

        $mailService    = new MailService();
        $mailService->sendContactConfirm($data);
        $mailService->sendContactInfo($data);

        return redirect()->route($this->controllerName . '/index')->with('success_notify', 'Thanks for contacting us! We will contact you soon!');
    }
}