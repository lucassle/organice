@php
    use App\Helpers\Template;
    use App\Helpers\URL;

    $xhtmlCategory  = sprintf('<li><a href="%s">All</a></li>', route('blog'));
    $xhtmlRecent    = '';

    foreach ($itemCategory as $value) {
        $linkCategory   = URL::linkCategoryArticle($value["id"], $value["name"]);
        $class          = '';
        if ($itemArticle['category_id'] == $value['id']) {
            $class  = 'active';
        }
        $xhtmlCategory .= sprintf('<li class="%s"><a href="%s">%s</a></li>', $class, $linkCategory, $value['name']);
    }
    $arrTag = json_encode($itemArticle['tag'], 0);
@endphp

@extends('shop.main')
@section('content')
@include('shop.block.hero', ['pageIndex' => true])
@include('shop.elements.breadcrumb-article', ['itemArticle' => $itemArticle])

<!-- Blog Details Section Begin -->
<section class="blog-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5 order-md-1 order-2">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__search">
                        <form action="#">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Categories</h4>
                        <ul>
                            {!! $xhtmlCategory !!}
                        </ul>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Recent News</h4>
                        <div class="blog__sidebar__recent">
                            @foreach ($itemRecent as $item)
                                <a href="{{ URL::linkArticle($item['id'], $item['title']) }}" class="blog__sidebar__recent__item">
                                    <div class="blog__sidebar__recent__item__pic">
                                        <img src="{{ asset('image/article/' . $item['thumb']) }}" alt="">
                                    </div>
                                    <div class="blog__sidebar__recent__item__text">
                                        <h6>{{ $item['title'] }}</h6>
                                        <span>{{ date_format(date_create($item['created']), "D m, Y") }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Search By</h4>
                        <div class="blog__sidebar__item__tags">
                            <a href="#">Apple</a>
                            <a href="#">Beauty</a>
                            <a href="#">Vegetables</a>
                            <a href="#">Fruit</a>
                            <a href="#">Healthy Food</a>
                            <a href="#">Lifestyle</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7 order-md-1 order-1">
                <div class="blog__details__text">
                    <img src="{{ asset('image/article/' . $itemArticle['thumb']) }}" alt="{{ $itemArticle['title'] }}">
                    {!! $itemArticle['content'] !!}
                </div>
                <div class="blog__details__content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="blog__details__author">
                                <div class="blog__details__author__pic">
                                    <img src="{{ asset('image/user/' . $itemArticle['avatar']) }}" alt="">
                                </div>
                                <div class="blog__details__author__text">
                                    <h6>{{ $itemArticle['fullname'] }}</h6>
                                    <span>{{ $itemArticle['created_by'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="blog__details__widget">
                                <ul>
                                    <li><span>Categories:</span> {{ $itemArticle['category'] }}</li>
                                    <li><span>Tags:</span> {{ $arrTag }}</li>
                                </ul>
                                <div class="blog__details__social">
                                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                    <a href="#"><i class="fa-brands fa-google-plus"></i></a>
                                    <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                                    <a href="#"><i class="fa-brands fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->

@if (!empty($itemArticle['related_item']))
<!-- Related Blog Section Begin -->
    <section class="related-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related-blog-title">
                        <h2>Post You May Like</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($itemArticle['related_item'] as $item)
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="{{ asset('image/article/' . $item['thumb']) }}" alt="{{ $item['title'] }}">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar"></i> {{ date_format(date_create($item['created']), "D m, Y") }}</li>
                                </ul>
                                <h5><a href="{{ URL::linkArticle($item['id'], $item['title']) }}">{{ $item['title'] }}</a></h5>
                                {!! substr($item['content'], 0, 100) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
<!-- Related Blog Section End -->
@endif


@endsection