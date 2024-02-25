@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;
@endphp

@extends('shop.register')
@section('content')
    <div class="brand">
        <a href="{{ route("home") }}"><img src="{{ asset("shop/img/logo.png") }}"></a>
    </div>
    <div class="card fat">
        <div class="card-body">
            <h4 class="card-title">Sign In Successful!</h4>
                <img src="{{ asset('login/good-job.png') }}" alt="Successful" class="img-login">
                <div class="form-group no-margin">
                    <a href="{{ route('auth/login') }}" class="btn btn-login btn-block">
                        Log in right now!
                    </a>
                </div>
        </div>
    </div>
    <div class="footer">
        Copyright &copy; Organice 2023
    </div>
@endsection