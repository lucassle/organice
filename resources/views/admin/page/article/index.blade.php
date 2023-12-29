@extends('admin.main')
@php
    use App\Helpers\Template as Template;
    use App\Models\CategoryArticleModel;

    $buttonFilter   = Template::showItemFilter($controllerName, $countByStatus, $arrParam['filter']['status'], $arrParam['search']);
    $areaSearch     = Template::showAreaSearch($controllerName, $arrParam['search']);

    $categoryModel  = new CategoryArticleModel();
    $itemCategory   = $categoryModel->listItems($arrParam, ['task' => 'admin-list-items-in-select-box-for-article']);
    
    $formInputAttr   = config('return.template.form_input');

@endphp
@section('content')
@include('admin.templates.page_header', ['pageIndex' => true])
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Filter'])
            <div class="x_content">
                <div class="row">
                    <div class="col-md-4"> {!! $buttonFilter !!} </div>
                    <div class="col-md-2"> {!! Form::select('filter_category', ['all' => 'All'] + $itemCategory, 
                    request()->get('filter_category', 'all'), $formInputAttr + ['data-url' => '']) !!} </div>
                    <div class="col-md-6"> {!! $areaSearch !!} </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'List'])
            @include('admin.page.article.list')
        </div>
    </div>
</div>

@if (count($items) > 0)
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Pagination'])
                @include('admin.templates.pagination')
            </div>
        </div>
    </div>
@endif
@endsection