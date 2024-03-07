@php
    use App\Helpers\Template;
    use App\Helpers\URL;

    $xhtmlRelated   = '';

    $linkCategory   = URL::linkCategoryProduct($itemDetail['category_id'], $itemDetail['category']);
    if ($itemDetail['sale_off'] > 0) {
        $price  = $itemDetail['price'] - ($itemDetail['price'] * $itemDetail['sale_off'] / 100);
    }

    $available  = ($itemDetail['quantity'] > 0) ? 'In Stock' : 'Out Of Stock';
@endphp

@extends('shop.main')
@section('content')
@include('shop.block.hero', ['pageIndex' => true])

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset("shop/img/breadcrumb.jpg") }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{ $itemDetail['name'] }}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ $linkCategory }}">{{ $itemDetail['category'] }}</a>
                        <span>{{ $itemDetail['name'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
@include('shop.templates.message')
<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img class="product__details__pic__item--large"
                            src="{{ asset('image/product/' . $itemDetail['thumb']) }}" alt="">
                    </div>
                    {{-- <div class="product__details__pic__slider owl-carousel">
                        <img data-imgbigurl="img/product/details/product-details-2.jpg"
                            src="img/product/details/thumb-1.jpg" alt="">
                        <img data-imgbigurl="img/product/details/product-details-3.jpg"
                            src="img/product/details/thumb-2.jpg" alt="">
                        <img data-imgbigurl="img/product/details/product-details-5.jpg"
                            src="img/product/details/thumb-3.jpg" alt="">
                        <img data-imgbigurl="img/product/details/product-details-4.jpg"
                            src="img/product/details/thumb-4.jpg" alt="">
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3>{{ $itemDetail['name'] }}</h3>
                    <div class="product__details__rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        {{-- <span>(18 reviews)</span> --}}
                    </div>
                    @if ($itemDetail['sale_off'] > 0)
                        <div class="product__details__discount__price">${{ number_format($price, 2, '.', ' ') }} <span> ${{ $itemDetail['price'] }}</span></div>
                    @else
                        <div class="product__details__price">${{ $itemDetail['price'] }}</div>
                    @endif
                    @if ($itemDetail['quantity'] > 0)
                        <form action="{{ URL::linkAddToCart($itemDetail['id']) }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $itemDetail['id'] }}">
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input value="1" name="quantities" class="quantities">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="primary-btn">ADD TO CARD</button>
                        </form>
                    @else
                        <span>Sorry! This item is out of stock! </span>
                    @endif
                    
                    <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                    <ul>
                        <li><b>Availability</b> <span>{{ $available }}</span></li>
                        <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                        <li><b>Weight</b> <span>0.5 kg</span></li>
                        <li><b>Share on</b>
                            <div class="share">
                                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#"><i class="fa-brands fa-pinterest"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                aria-selected="true">Description</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                aria-selected="false">Information</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                aria-selected="false">Reviews <span>(1)</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>{{ $itemDetail['description'] }}</p>
                            </div>
                        </div>
                        {{-- <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                    Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                    Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                    sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                    eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                    Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                    sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                    diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                    Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                    Proin eget tortor risus.</p>
                                <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                    ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                    elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                    porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                    nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</p>
                            </div>
                        </div> --}}
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                    Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                    Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                    sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                    eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                    Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                    sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                    diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                    Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                    Proin eget tortor risus.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Details Section End -->

<!-- Related Product Section Begin -->
@if (!empty($itemDetail['related_item']))
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Related Product</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($itemDetail['related_item'] as $item)
                    @if ($item['sale_off'] > 0)
                        <div class="col-lg-4">
                            <div class="product__discount__item">
                                <div class="product__discount__item__pic set-bg" data-setbg="{{ asset('image/product/' . $item['thumb']) }}">
                                    <div class="product__discount__percent">-{{ $item['sale_off'] }} </div>
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                        <li><a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__discount__item__text">
                                    <h5><a href="{{ URL::linkProduct($item['id'], $item['name']) }}">{{ $item['name'] }}</a></h5>
                                    <div class="product__item__price">${{ number_format($item['price'] - ($item['price'] * $item['sale_off'] / 100), 2, '.', ' ') }}<span>${{ $item['price'] }}</span></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ asset('image/product/' . $item['thumb']) }}">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{ URL::linkProduct($item['id'], $item['name']) }}">{{ $item['name'] }}</a></h6>
                                    <h5>${{ $item['price'] }}</h5>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endif
<!-- Related Product Section End -->


@endsection