@extends('shop.login')
@section('content')
    @php
        use App\Helpers\Form as FormTemplate;
    @endphp
    <div class="brand">
        <a href="{{ route("home") }}"><img src="{{ asset("shop/img/logo.png") }}"></a>
    </div>
    <div class="card fat">
        <div class="card-body">
            <h4 class="card-title">Login</h4>
            @include('shop.templates.error')
            @include('shop.templates.login_notify')
                {!! Form::open([
                    'method' => 'POST',
                    'url'    => route("$controllerName/postLogin"),
                    'id'     => 'auth-form'
                ]) !!}
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password', ['class' => 'form-control', 'required' => true, 'data-eye' => true]) !!}
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>

                <div class="form-group no-margin">
                    <button type="submit" class="btn btn-login btn-block">
                        Login
                    </button>
                </div>
                <div class="margin-top20 text-center">
                    Don't have an account? <a href="register.html">Create One</a>
                </div>
                {!! Form::close() !!}
        </div>
    </div>
    <div class="footer">
        Copyright &copy; Organice 2023
    </div>
@endsection