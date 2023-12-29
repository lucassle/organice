@extends('shop.main')
@section('content')

@include('shop.block.hero', ['pageIndex' => false])
<div class="content_container">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-12">
                <div class="main_content">
                    <h3>You don't have permission to access this site!! </h3>
                    <a href="{{ route('home') }}">Click here to go back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection