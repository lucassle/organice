@extends('shop.main')
@section('content')
@include('shop.block.hero', ['pageIndex' => true])

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('shop/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Order Detail</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="vh-100" style="background-color: white;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12">
            <div class="card card-stepper text-black" style="border-radius: 16px;">
    
                <div class="card-body p-5">
    
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div>
                    <h5 class="mb-0">INVOICE <span class="font-weight-bold" style="color:#7fad39">#Y34XDHR</span></h5>
                    </div>
                    <div class="text-end">
                    <p class="mb-0">Time Order <span>01/12/19</span></p>
                    <p class="mb-0"> <span class="font-weight-bold">234094567242423422898</span></p>
                    </div>
                </div>
    
                <ul id="progressbar-2" class="d-flex justify-content-between mx-0 mt-0 mb-5 px-0 pt-0 pb-2">
                    <li class="step0 active text-center" id="step1"></li>
                    <li class="step0 active text-center" id="step2"></li>
                    <li class="step0 active text-center" id="step3"></li>
                    <li class="step0 text-muted text-end" id="step4"></li>
                </ul>
    
                <div class="d-flex justify-content-between">
                    <div class="d-lg-flex align-items-center">
                    <i class="fas fa-clipboard-list fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                    <div>
                        <p class="fw-bold mb-1">Order</p>
                        <p class="fw-bold mb-0">Processed</p>
                    </div>
                    </div>
                    <div class="d-lg-flex align-items-center">
                    <i class="fas fa-box-open fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                    <div>
                        <p class="fw-bold mb-1">Order</p>
                        <p class="fw-bold mb-0">Shipped</p>
                    </div>
                    </div>
                    <div class="d-lg-flex align-items-center">
                    <i class="fas fa-shipping-fast fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                    <div>
                        <p class="fw-bold mb-1">Order</p>
                        <p class="fw-bold mb-0">En Route</p>
                    </div>
                    </div>
                    <div class="d-lg-flex align-items-center">
                    <i class="fas fa-home fa-3x me-lg-4 mb-3 mb-lg-0"></i>
                    <div>
                        <p class="fw-bold mb-1">Order</p>
                        <p class="fw-bold mb-0">Arrived</p>
                    </div>
                    </div>
                </div>
    
                </div>
    
            </div>
            </div>
        </div>
    </div>
</section>
<!-- Checkout Section End -->

@endsection