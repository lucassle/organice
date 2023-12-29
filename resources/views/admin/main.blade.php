<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.elements.head')
</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            @include('admin.elements.sidebar')
        </div>
        <div class="top_nav">
            @include('admin.elements.top_nav')
        </div>
        <div class="right_col" role="main">
            @yield('content')
        </div>
            @include('admin.elements.footer')
        </div>
    </div>
    @include('admin.elements.script')
    @yield('after_script')
</body>
</html>