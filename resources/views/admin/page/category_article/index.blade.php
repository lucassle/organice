@extends('admin.main')
@php
    use App\Helpers\Template as Template;
    $buttonFilter   = Template::showItemFilter($controllerName, $countByStatus, $arrParam['filter']['status'], $arrParam['search']);
    $areaSearch     = Template::showAreaSearch($controllerName, $arrParam['search']);
@endphp
@section('content')
@include('admin.templates.page_header', ['pageIndex' => true])

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'List'])
            @include('admin.page.category_article.list')
        </div>
    </div>
</div>
@endsection