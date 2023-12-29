@php
    use App\Helpers\URL;

    $xhtmlLatest    = '';
    $xhtmlCategory  = sprintf('<li><a href="%s">All</a></li>', route('blog'));
    $xhtmlTag       = '';
    
    if (!empty($itemRecent)) {
        foreach ($itemRecent as $value) {
            $linkArticle    = URL::linkArticle($value['id'], $value['title']);
            $created    = date_format(date_create($value['created']), "D m, Y");
            $xhtmlLatest .= sprintf('<a href="%s" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic"">
                                            <img src="image/blog/%s" alt="">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h6>%s</h6>
                                            <span>%s</span>
                                        </div>
                                    </a>', $linkArticle, $value['thumb'], $value['title'], $created);
        }
    }

    if (!empty($itemCategory)) {
        $categoryIdCurrent  = Route::input('blog_id');
        foreach ($itemCategory as $value) {
            $classActive    = ($categoryIdCurrent == $value['id']) ? 'class="active"' : '';
            $linkCategory   = URL::linkCategoryArticle($value["id"], $value["name"]);
            $xhtmlCategory .= sprintf('<li %s><a href="%s">%s</a></li>', $classActive, $linkCategory, $value['name']);
        }
    }

    if (!empty($itemBlog)) {
        foreach ($itemBlog as $value) {
            $arrTag     = explode(", ",$value['tag']);
            if (!empty($arrTag)) {
                foreach ($arrTag as $key => $value) {
                    $xhtmlTag .= sprintf('<a href="#">%s</a>', $value);
                }
            }
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
                    <h2>Blog</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('blog') }}">Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
                            {{-- {!! $xhtmlLatest !!} --}}
                            @foreach ($itemRecent as $item)
                                <a href="{{ URL::linkArticle($item['id'], $item['title']) }}" class="blog__sidebar__recent__item">
                                    <div class="blog__sidebar__recent__item__pic">
                                        <img src="{{ asset('image/article/' . $item['thumb']) }}" alt="{{ $item['title'] }}">
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
                            {!! $xhtmlTag !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="row">
                    @if (!empty($itemInCategory['article']))
                        @foreach ($itemInCategory['article'] as $item)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog__item">
                                    <div class="blog__item__pic">
                                        <img src="{{ asset('image/article/' . $item['thumb']) }}" alt="{{ $item['title'] }}">
                                    </div>
                                    <div class="blog__item__text">
                                        <ul>
                                            <li><i class="fa fa-calendar"></i>{{ date_format(date_create($item['created']), "D m, Y") }}</li>
                                        </ul>
                                        <h5><a href="{{ URL::linkArticle($item['id'], $item['title']) }}">{{ $item['title'] }}</a></h5>
                                        <p>{!! substr($item['content'], 0, 100) !!}</p>
                                        <a href="{{ URL::linkArticle($item['id'], $item['title']) }}" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if (count($itemInCategory['article']) > 6)
                            <div class="col-lg-12">
                                <div class="product__pagination blog__pagination">
                                    <a href="#">1</a>
                                    <a href="#">2</a>
                                    <a href="#">3</a>
                                    <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        @endif
                    @else
                        <h4>There is no blog!</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection