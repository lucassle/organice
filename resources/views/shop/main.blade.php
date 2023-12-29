<!DOCTYPE html>
<html lang="zxx">

<head>
    @include('shop.elements.head')
</head>

<body>
    @include('shop.elements.page_loader')

    @include('shop.elements.humberger')

    @include('shop.elements.header')

    @yield('content')

    @include('shop.elements.footer')

    @include('shop.elements.script')
</body>

</html>