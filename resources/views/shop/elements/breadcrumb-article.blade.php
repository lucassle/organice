@php
    use App\Helpers\URL;

    $categoryName   = lcfirst(URL::linkCategoryArticle($itemArticle['category_id'], $itemArticle['category']));
@endphp

<section class="breadcrumb-section set-bg" data-setbg="{{ asset('shop/img/blog/details/details-hero.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="blog__details__hero__text">
                    <h2>{{ $itemArticle['title'] }}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ $categoryName }}">{{ $itemArticle['category'] }}</a>
                        <span>{{ $itemArticle['title'] }}</span>
                        <ul>
                            <li>By {{ $itemArticle['created_by'] }}</li>
                            <li>{{ date_format(date_create($itemArticle['created']), "D m, Y") }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>