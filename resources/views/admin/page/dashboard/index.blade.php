@extends('admin.main')
@section('content')
<div class="page-header zvn-page-header clearfix">
    <div class="zvn-page-header-title">
        <h3>Dashboard</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Home'])
            <div class="x_content">
                <div class="row">
                    @include('admin.page.dashboard.list_general', ['item' => $totalMenu, 'name' => 'menu', 'icon' => 'fa-bars'])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'User Manager'])
            <div class="x_content">
                <div class="row">
                    @include('admin.page.dashboard.list_general', ['item' => $totalUser, 'name' => 'user', 'icon' => 'fa-user'])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Product Manager'])
            <div class="x_content">
                <div class="row">
                    @include('admin.page.dashboard.list_general', ['item' => $totalBanner, 'name' => 'banner', 'icon' => 'fa-sliders'])
                    @include('admin.page.dashboard.list_general', ['item' => $totalProduct, 'name' => 'product', 'icon' => 'fa-lemon'])
                    @include('admin.page.dashboard.list_general', ['item' => $totalAttribute, 'name' => 'attribute', 'icon' => 'fa-file-pen'])
                    @include('admin.page.dashboard.list_general', ['item' => $totalCategoryProduct, 'name' => 'categoryProduct', 'icon' => 'fa-folder-open'])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Sales Manager'])
            <div class="x_content">
                <div class="row">
                    @include('admin.page.dashboard.list_general', ['item' => $totalCoupon, 'name' => 'coupon', 'icon' => 'fa-ticket'])
                    @include('admin.page.dashboard.list_general', ['item' => $totalShippingCost, 'name' => 'shippingCost', 'icon' => 'fa-truck'])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Blog Manager'])
            <div class="x_content">
                <div class="row">
                    @include('admin.page.dashboard.list_general', ['item' => $totalArticle, 'name' => 'article', 'icon' => 'fa-blog'])
                    @include('admin.page.dashboard.list_general', ['item' => $totalCategoryArticle, 'name' => 'categoryArticle', 'icon' => 'fa-folder-open'])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Contact Manager'])
            <div class="x_content">
                <div class="row">
                    @include('admin.page.dashboard.list_general', ['item' => $totalRecall, 'name' => 'recall', 'icon' => 'fa-phone'])
                    @include('admin.page.dashboard.list_general', ['item' => $totalContact, 'name' => 'contact', 'icon' => 'fa-address-book'])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Media Manager'])
            <div class="x_content">
                <div class="row">
                    @include('admin.page.dashboard.list_setting', ['name' => 'Gallery', 'route' => 'gallery', 'icon' => 'fa-image'])
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            @include('admin.templates.x_title', ['title' => 'Config'])
            <div class="x_content">
                <div class="row">
                    @include('admin.page.dashboard.list_setting', ['name' => 'Logs Viewer', 'route' => 'logs', 'icon' => 'fa-exclamation'])
                    @include('admin.page.dashboard.list_setting', ['name' => 'Change Password', 'route' => 'password', 'icon' => 'fa-key'])
                    @include('admin.page.dashboard.list_setting', ['name' => 'Setting', 'route' => 'setting', 'icon' => 'fa-gear'])
                </div>
            </div>
        </div>
    </div>
</div>

@endsection