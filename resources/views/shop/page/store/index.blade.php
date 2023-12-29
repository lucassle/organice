@php
    use App\Helpers\Template;
    use App\Helpers\URL;

    $xhtmlCategory          = sprintf('<li><a href="%s">All</a></li>', route('store'));
    $xhtmlSale              = '';
    $xhtmlStore             = '';
    $xhtmlLatest            = '';
    
    if (!empty($itemCategory)) {
        $currentID      = Route::input('category_id');
        foreach ($itemCategory as $value) {
            $linkCategory   = URL::linkCategoryProduct($value["id"], $value["name"]);
            $xhtmlCategory  .= sprintf('<li><a href="%s">%s</a></li>', $linkCategory, $value['name']);
        }
    }

    if (!empty($itemSale)) {
        foreach ($itemSale as $value) {
            $linkProduct    = URL::linkProduct($value["id"], $value["name"]);
            $oldPrice       = $value['price'];
            $newPrice       = $value['price'] - ($value['price'] * $value['sale_off'] / 100);
            $xhtmlSale      .= sprintf('<div class="col-lg-4">
                                        <div class="product__discount__item">
                                            <div class="product__discount__item__pic set-bg"
                                                data-setbg="image/product/%s">
                                                <div class="product__discount__percent">-%s</div>
                                                <ul class="product__item__pic__hover">
                                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="product__discount__item__text">
                                                <span>%s</span>
                                                <h5><a href="%s">%s</a></h5>
                                                <div class="product__item__price">$%s <span>$%s</span></div>
                                            </div>
                                        </div>
                                    </div>', $value['thumb'], $value['sale_off'] . "%", $value['category'], $linkProduct, $value['name'], number_format($newPrice, 2, '.', ' '), $oldPrice);
        }
    }

    if (!empty($itemProduct)) {
        foreach ($itemProduct as $value) {
            $_SESSION['token'] = md5(uniqid(mt_rand(), true));
            $linkProduct    = URL::linkProduct($value["id"], $value["name"]);
            if ($value['sale_off'] > 0) {
                $oldPrice   = $value['price'];
                $newPrice   = $value['price'] - ($value['price'] * 20 / 100);
                $xhtmlStore .= sprintf('<div class="col-lg-4">
                                            <div class="product__discount__item">
                                                <div class="product__discount__item__pic set-bg" data-setbg="image/product/%s">
                                                    <div class="product__discount__percent">-%s</div>
                                                    <ul class="product__item__pic__hover">
                                                        <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                        <li>
                                                            <form action="%s" method="post">
                                                                <input type="hidden" name="_token" value="%s">
                                                                <input type="hidden" name="product_id" value="%s">
                                                                <input type="hidden" name="quantities" value="1">
                                                                <button type="submit"><i class="fa fa-shopping-cart"></i></button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="product__discount__item__text">
                                                    <h5><a href="%s">%s</a></h5>
                                                    <div class="product__item__price">$%s<span>$%s</span></div>
                                                </div>
                                            </div>
                                        </div>', $value['thumb'], $value['sale_off'] . "%", URL::linkAddToCart($value['id']), $_SESSION['token'], $value['id'], $linkProduct, $value['name'], number_format($newPrice, 2, '.', ' '), $oldPrice);
            } else {
                $xhtmlStore .= sprintf('<div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="product__item">
                                                <div class="product__item__pic set-bg" data-setbg="image/product/%s">
                                                    <ul class="product__item__pic__hover">
                                                        <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                        <li>
                                                            <form action="%s" method="post">
                                                                <input type="hidden" name="_token" value="%s">
                                                                <input type="hidden" name="product_id" value="%s">
                                                                <input type="hidden" name="quantities" value="1">
                                                                <button type="submit"><i class="fa fa-shopping-cart"></i></button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="product__item__text">
                                                    <h6><a href="%s">%s</a></h6>
                                                    <h5>$%s</h5>
                                                </div>
                                            </div>
                                        </div>', $value['thumb'], URL::linkAddToCart($value['id']), $_SESSION['token'], $value['id'], $linkProduct, $value['name'], $oldPrice);
            }  
        }
    } else {
        $xhtmlStore = sprintf('<div style="margin:auto"><strong>Updating!</strong></div>');
    }

    $sortByPrice    = Template::sortByPrice($controllerName, $arrParam['filter']['sort']);
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
                    <h2>Organice Shop</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- @include('shop.elements.breadcrumb') --}}
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
                <div class="product__discount">
                    <div class="section-title product__discount__title">
                        <h2>Sale Off</h2>
                    </div>
                    <div class="row">
                        <div class="product__discount__slider owl-carousel">
                            {!! $xhtmlSale !!}
                        </div>
                    </div>
                </div>
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sort By Price</span>
                                {!! $sortByPrice !!}
                                {{-- <select>
                                    <option value="0">Ascending</option>
                                    <option value="0">Descending</option>
                                </select> --}}
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span>{{ count($itemProduct) }}</span> Products found</h6>
                            </div>
                        </div>
                        {{-- <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="row">
                   {{-- {!! $xhtmlStore !!} --}}
                    @if (!empty($itemProduct))
                        @foreach ($itemSale as $value)
                            @if ($value['sale_off'] > 0)
                                <div class="col-lg-4">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="{{ asset('image/product/' . $value['thumb']) }}">
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li>
                                                    <form action="{{ URL::linkAddToCart($value['id']) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $value['id'] }}">
                                                        <input type="hidden" name="quantities" value="1">
                                                        <button type="submit"><i class="fa fa-shopping-cart"></i></button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product__item__text">
                                            <h5><a href="{{ URL::linkProduct($value["id"], $value["name"]) }}">{{ $value['name'] }}</a></h5>
                                            <div class="product__item__price">${{ number_format($value['price'] - ($value['price'] * 20 / 100), 2, '.', ' ') }} <span>${{ $value['price'] }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="{{ asset('image/product/' . $value['thumb']) }}">
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li>
                                                    <form action="{{ URL::linkAddToCart($value['id']) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $value['id'] }}">
                                                        <input type="hidden" name="quantities" value="1">
                                                        <button type="submit"><i class="fa fa-shopping-cart"></i></button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product__item__text">
                                            <h6><a href="{{ URL::linkProduct($value["id"], $value["name"]) }}">{{ $value['name'] }}</a></h6>
                                            <h5>${{ $value['price'] }}</h5>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div style="margin:auto"><strong>Updating!</strong></div>
                    @endif
                </div>
                @if (count($itemProduct) > 9)
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