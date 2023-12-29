@extends('admin.main')

@section('content')
    @include('admin.templates.page_header', ['pageIndex' => false])
    @include('admin.templates.error')

    @if (!empty($items['id']))
        <div class="row">
            @include('admin.page.user.form_info')
            @include('admin.page.user.form_change_password')
            @include('admin.page.user.form_change_level')
        </div>
    @else
        @include('admin.page.user.form_add')
    @endif
@endsection