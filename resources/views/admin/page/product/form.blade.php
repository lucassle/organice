@extends('admin.main')
@section('content')
    @include('admin.templates.page_header', ['pageIndex' => false])
    @include('admin.templates.error')

    @if (!empty($items['id']))
        <div class="row">
            @include('admin.page.product.form_info')
            @include('admin.page.product.form_category')
            {{-- @include('admin.page.product.form_seo') --}}
            @include('admin.page.product.form_attribute')
        </div>
    @else
        @include('admin.page.product.form_add')
    @endif
@endsection