@php
    use App\Helpers\URL;

    $xhtmlBlog      = '';
    $xhtmlLatest    = '';
    $xhtmlCategory  = sprintf('<li><a href="%s">All</a></li>', route('blog'));
    $xhtmlTag       = '';
    if (!empty($itemBlog)) {
        foreach ($itemBlog as $value) {
            $linkArticle    = URL::linkArticle($value['id'], $value['title']);
            $created        = date_format(date_create($value['created']), "D m, Y");
            $arrTag         = explode(", ",$value['tag']);
            $xhtmlBlog      .= sprintf('<div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="blog__item">
                                                <div class="blog__item__pic">
                                                    <img src="image/article/%s" alt="">
                                                </div>
                                                <div class="blog__item__text">
                                                    <ul>
                                                        <li><i class="fa fa-calendar"></i>%s</li>
                                                    </ul>
                                                    <h5><a href="%s">%s</a></h5>
                                                    <p>%s</p>
                                                    <a href="%s" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                                </div>
                                            </div>
                                        </div>', $value['thumb'], $created, $linkArticle, $value['title'], substr($value['content'], 0, 100), $linkArticle);
            if (!empty($arrTag)) {
                foreach ($arrTag as $key => $value) {
                    $xhtmlTag .= sprintf('<a href="#">%s</a>', $value);
                }
            }
            

        }
    }

    if (!empty($itemLatest)) {
        foreach ($itemLatest as $value) {
            $linkArticle    = URL::linkArticle($value['id'], $value['title']);
            $created    = date_format(date_create($value['created']), "D m, Y");
            $xhtmlLatest .= sprintf('<a href="%s" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic"">
                                            <img src="image/article/%s" alt="">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h6>%s</h6>
                                            <span>%s</span>
                                        </div>
                                    </a>', $linkArticle, $value['thumb'], $value['title'], $created);
        }
    }

    if (!empty($itemCategory)) {
        foreach ($itemCategory as $value) {
            $linkCategory   = URL::linkCategoryArticle($value["id"], $value["name"]);
            $xhtmlCategory .= sprintf('<li><a href="%s">%s</a></li>', $linkCategory, $value['name']);
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
                    <h2>{{ $controllerName }}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('blog') }}">Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- @include('shop.elements.breadcrumb', ['item' => $itemCategory]) --}}
<!-- Breadcrumb Section End -->

<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="blog__sidebar">
                    {{-- <div class="blog__sidebar__search">
                        <form action="#">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div> --}}
                    <div class="blog__sidebar__item">
                        <h4>Categories</h4>
                        <ul>
                            {!! $xhtmlCategory !!}
                        </ul>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Recent News</h4>
                        <div class="blog__sidebar__recent">
                            {!! $xhtmlLatest !!}
                        </div>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Search By</h4>
                        <div class="blog__sidebar__item__tags">
                            {!! $xhtmlTag !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="row">
                    {!! $xhtmlBlog !!}
                    @if (count($itemBlog) > 6)
                        <div class="col-lg-12">
                            <div class="product__pagination blog__pagination">
                                <a href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection