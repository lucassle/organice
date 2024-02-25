@extends('shop.main')
@section('content')
@include('shop.block.hero', ['pageIndex' => true])

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('shop/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Thanks for shopping</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
{{-- <section class="checkout spad">
    <div class="container">
        <div class="row">
            <img src="{{ asset('shop/img/thanks.jpg') }}" alt="Thanks-for-shopping"  style="margin:auto">
        </div>
        <a href="{{ route('home') }}" class="redirect-link">Back to store here</a>
    </div>
</section> --}}
<div class="content_container">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-12">
                <div class="main_content">
                    <img src="{{ asset('shop/img/thanks.jpg') }}" alt="Thanks-for-shopping"  style="margin:auto;margin-top:20px">
                    <h3>Thanks for shopping!</h3>
                    <a href="{{ route('home') }}">Click here to go back</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout Section End -->

@endsection