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
            <h4 class="card-title">Sign In</h4>
            @include('shop.templates.error')
            @include('shop.templates.login_notify')
                {!! Form::open([
                    'method'    => 'POST',
                    'url'       => route("$controllerName/postRegister"),
                    'id'        => 'auth-form',
                    'enctype'   => 'multipart/form-data'
                ]) !!}
                <div class="form-group">
                    {!! Form::label('username', 'Username') !!}
                    {!! Form::text('username', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('fullname', 'Fullname') !!}
                    {!! Form::text('fullname', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password', ['class' => 'form-control', 'required' => true, 'data-eye' => true]) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Password Confirmation') !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => true, 'data-eye' => true]) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('avatar', 'Avatar') !!}
                    {!! Form::file('avatar', ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                </div>

                <div class="form-group no-margin">
                    <button type="submit" class="btn btn-login btn-block">
                        Sign in
                    </button>
                </div>
                <div class="margin-top20 text-center">
                    Already have an account? <a href="{{ route('auth/login') }}">Login here!</a>
                    <br>
                </div>
                <div class="text-center">
                    Or <a href="{{ route('store') }}">Back to store</a>
                </div>
                {!! Form::close() !!}
        </div>
    </div>
    <div class="footer">
        Copyright &copy; Organice 2023
    </div>
@endsection