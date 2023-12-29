@php
    use App\Helpers\Template;
    use App\Helpers\URL;

    $xhtmlSlider    = '';
    $xhtmlBanner    = '';
    $xhtmlFeature   = '';
    $xhtmlLatest    = '';
    $xhtmlBlog      = '';

    if (!empty($itemSlider)) {
        foreach ($itemSlider as $key => $value) {
            $linkCategory   = URL::linkCategoryProduct($value['category_id'], $value['category']);
            $xhtmlSlider    .= sprintf(' <div class="col-lg-3">
                                            <div class="categories__item set-bg" data-setbg="image/product/%s">
                                                <h5><a href="%s">%s</a></h5>
                                            </div>
                                        </div>', $value['thumb'], $linkCategory, $value['category']);
        }
    }
    
    if (!empty($itemBanner)) {
        foreach ($itemBanner as $key => $value) {
            $xhtmlBanner .= sprintf('<div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="banner__pic">
                                            <img src="image/banner/%s" alt="%s">
                                        </div>
                                    </div>', $value['thumb'], $value['name']);
        }
    }

    if (!empty($itemFeature)) {
        foreach ($itemFeature as $value) {
            $linkProduct    = URL::linkProduct($value["id"], $value["name"]);
            $xhtmlFeature .= sprintf('<div class="col-lg-3 col-md-4 col-sm-6 %s">
                                        <div class="featured__item">
                                            <div class="featured__item__pic set-bg" data-setbg="image/product/%s">
                                                <ul class="featured__item__pic__hover">
                                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="featured__item__text">
                                                <h6><a href="%s">%s</a></h6>
                                                <h5>$%s</h5>
                                            </div>
                                        </div>
                                    </div>', $value['category'], $value['thumb'], $linkProduct, $value['name'], $value['price']);
        }
    }

    if (!empty($itemBlog)) {
        foreach ($itemBlog as $value) {
            $linkArticle    = URL::linkArticle($value['id'], $value['title']);
            $created    = date_format(date_create($value['created']), "D m, Y");
            $xhtmlBlog .= sprintf('<div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="image/article/%s" alt="%s">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar"></i> %s</li>
                        </ul>
                        <h5><a href="%s">%s</a></h5>
                        %s...
                    </div>
                </div>
            </div>', $value['thumb'], $value['title'], $created, $linkArticle, $value['title'], substr($value['content'], 0, 100));
        }
    }
@endphp

@extends('shop.main')
@section('content')

@include('shop.block.hero', ['pageIndex' => false])

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                {!! $xhtmlSlider !!}
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Featured Product</h2>
                </div>
                {{-- <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        <li data-filter=".oranges">Oranges</li>
                        <li data-filter=".fresh-meat">Fresh Meat</li>
                        <li data-filter=".vegetables">Vegetables</li>
                        <li data-filter=".fastfood">Fastfood</li>
                    </ul>
                </div> --}}
            </div>
        </div>
        <div class="row featured__filter">
            {{-- {!! $xhtmlFeature !!} --}}
            @foreach ($itemFeature as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 %s">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="{{ asset('image/product/' . $item['thumb']) }}">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="{{ URL::linkProduct($item["id"], $item["name"]) }}">{{ $item['name'] }}</a></h6>
                            @if ($item['sale_off'] > 0)
                                <div class="featured__discount__item__text">${!! number_format($item['price'] - ($item['price'] * $item['sale_off'] / 100), 2, '.', ' ') !!} <span>${{ $item['price'] }}</span></div>
                            @else
                                <h5>${{ $item['price'] }}</h5>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Section End -->

<!-- Banner Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            {!! $xhtmlBanner !!}
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
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
            <div class="col-lg-6 col-md-6">
                <div class="latest-product__text">
                    <h4>Top Rated Products</h4>
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
            {{-- <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Review Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-1.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-2.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-3.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                        </div>
                        <div class="latest-prdouct__slider__item">
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-1.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-2.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-3.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>Crab Pool Security</h6>
                                    <span>$30.00</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
<!-- Latest Product Section End -->

<!-- Blog Section Begin -->
<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title from-blog__title">
                    <h2>From The Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            {!! $xhtmlBlog !!}
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection