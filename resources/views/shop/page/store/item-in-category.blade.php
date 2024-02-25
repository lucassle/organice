@php
    use App\Helpers\Template;
    use App\Helpers\URL;

    $xhtmlCategory          = sprintf('<li><a href="%s">All</a></li>', route('store'));
    $xhtmlStore             = '';
    $xhtmlLatest            = '';
    
    if (!empty($itemCategory)) {
        $categoryIdCurrent      = Route::input('category_id');
        foreach ($itemCategory as $value) {
            $classActive        = ($categoryIdCurrent == $value['id']) ? 'class="active"' : '';
            $linkCategory       = URL::linkCategoryProduct($value["id"], $value["name"]);
            $xhtmlCategory      .= sprintf('<li %s><a href="%s">%s</a></li>', $classActive, $linkCategory, $value['name']);
        }
    }
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
                    <h2>{{ $itemInCategory['name'] }}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('store') }}">Shop</a>
                        <span>{{ $itemInCategory['name'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>Department</h4>
                        <ul>
                            {!! $xhtmlCategory !!}
                        </ul>
                    </div>
                    <div class="sidebar__item">
                        <h4>Price</h4>
                        <div class="price-range-wrap">
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="10" data-max="540">
                                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                {{-- <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span> --}}
                            </div>
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar__item">
                        <div class="latest-product__text">
                            <h4>Latest Products</h4>
                            <div class="latest-product__slider owl-carousel">
                                <div class="latest-prdouct__slider__item">
                                    @foreach ($itemLatest as $item)
                                        <a href="{!! URL::linkProduct($item['id'], $item['name']) !!}" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="{{ asset('image/product/' . $item['thumb']) }}" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>{{ $item['name'] }}</h6>
                                                @if ($item['sale_off'] > 0)
                                                    <span>${!! number_format($item['price'] - ($item['price'] * $item['sale_off'] / 100), 2, '.', ' ') !!}</span>
                                                @else
                                                    <span>${{ $item['price'] }}</span>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                <div class="latest-prdouct__slider__item">
                                    @foreach ($itemLatest as $item)
                                        <a href="{!! URL::linkProduct($item['id'], $item['name']) !!}" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="{{ asset('image/product/' . $item['thumb']) }}" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>{{ $item['name'] }}</h6>
                                                @if ($item['sale_off'] > 0)
                                                    <span>${!! number_format($item['price'] - ($item['price'] * $item['sale_off'] / 100), 2, '.', ' ') !!}</span>
                                                @else
                                                    <span>${{ $item['price'] }}</span>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-7">
                <div class="section-title product__discount__title">
                    <h2>{{ $itemInCategory['name'] }}</h2>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="filter__sort">
                            <span>Sort By Price</span>
                            {!! Template::sortByPrice($controllerName, $arrParam['filter']['sort']) !!}
                            {{-- <select>
                                <option value="0">Ascending</option>
                                <option value="0">Descending</option>
                            </select> --}}
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="filter__found">
                            <h6><span>{{ count($itemInCategory['product']) }}</span> Products found</h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- {!! $xhtmlStore !!} --}}
                    @foreach ($itemInCategory['product'] as $item)
                        @if ($item['sale_off'] > 0)
                            <div class="col-lg-4">
                                <div class="product__discount__item">
                                    <div class="product__discount__item__pic set-bg" data-setbg="{{ asset('image/product/' . $item['thumb']) }}">
                                        <div class="product__discount__percent">-{{ $item['sale_off'] }}</div>
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            @if ($item['quantity'] != 0)
                                                <li>
                                                    <form action="{{ URL::linkAddToCart($item['id']) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                                        <input type="hidden" name="quantities" value="1">
                                                        <button type="submit"><i class="fa fa-shopping-cart"></i></button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="product__discount__item__text">
                                        <h5><a href="{!! URL::linkProduct($item['id'], $item['name']) !!}">{{ $item['name'] }}</a></h5>
                                        <div class="product__item__price">${!! number_format($item['price'] - ($item['price'] * $item['sale_off'] / 100), 2, '.', ' ') !!}<span>${{ $item['price'] }}</span></div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{ asset('image/product/' . $item['thumb']) }}">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            @if ($item['quantity'] != 0)
                                                <li>
                                                    <form action="{{ URL::linkAddToCart($item['id']) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                                        <input type="hidden" name="quantities" value="1">
                                                        <button type="submit"><i class="fa fa-shopping-cart"></i></button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="{!! URL::linkProduct($item['id'], $item['name']) !!}">{{ $item['name'] }}</a></h6>
                                        <h5>${{ $item['price'] }}</h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                @if (count($itemInCategory['product']) > 9)
                    <div class="product__pagination">
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection