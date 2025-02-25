@extends('admin.main')
@php
    use App\Helpers\Template as Template;
    $buttonFilter   = Template::showItemFilter($controllerName, $countByStatus, $arrParam['filter']['status'], $arrParam['search']);
    $areaSearch     = Template::showAreaSearch($controllerName, $arrParam['search']);
@endphp
@section('content')
<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>Recall Request</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Filter'])
            <div class="x_content">
                <div class="row">
                    <div class="col-md-6"> {!! $buttonFilter !!} </div>
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
            @include('admin.page.recall.list')
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