@php
    use Gloudemans\Shoppingcart\Facades\Cart;
    use App\Helpers\Template;
    use App\Models\MenuModel;
    use App\Models\CategoryArticleModel;
    use App\Helpers\URL;

    $xhtmlUser  = '';
    $xhtmlMenu  = '';
    $xhtmlItemPrice  = '';
    $xhtmlCart  = '';
    $class      = '';

    $menuModel              = new MenuModel();
    $menu                   = $menuModel->listItems(null, ['task' => 'shop-list-items']);
    
    $xhtmlMenu              = '<nav class="humberger__menu__nav mobile-menu"><ul>';
    // $xhtmlMenu          = '<nav class="main_nav"><ul class="main_nav_list d-flex flex-row align-items-center justify-content-start">';
    foreach ($menu as $item) {
        $link               = $item["link"];
        switch ($item["type_menu"]) {
            case 'link':
                $xhtmlMenu          .= sprintf('<li><a href="%s" target="%s">%s</a></li>', $link, $item["type_menu"], $item['name']);
                break;
            
            case 'category_article':
                $xhtmlMenu          .= sprintf('<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" data-name="category_article" target="%s">%s <span class="caret"></span></a>', $item["type_menu"], $item['name']);
                
                $categoryModel      = new CategoryArticleModel();
                $category           = $categoryModel->listItems(null, ['task' => 'shop-list-items']);

                if (count($category) > 0) {
                    $xhtmlMenu      .= '<ul class="header__menu__dropdown">';
                    $xhtmlMenu      .= sprintf('<li><a href="%s" target="%s" data-parent="category_article">All</a></li>', route('blog'), $item["type_menu"]);
                    foreach ($category as $key => $value) {
                        $linkCategory       = URL::linkCategoryArticle($value["id"], $value["name"]);
                        $xhtmlMenu          .= sprintf('<li><a href="%s" target="%s" data-parent="category_article">%s</a></li>', $linkCategory, $item["type_menu"], $value['name']);
                    }
                    Template::showNestedMenu($category, $xhtmlMenu);
                    $xhtmlMenu       .= '</ul>';
                }
                $xhtmlMenu       .= '</li>';
                break;
            }
    };

    if (session('userInfo')) {
        // $xhtmlUser  = sprintf('<a href="%s"><i class="fa %s"></i> %s</a>', route('auth/logout'), 'fa-arrow-right-from-bracket','Logout');
        $xhtmlUser  = sprintf('<a href="%s"><img src="%s" alt="%s"> %s</a>', route('auth/logout'), asset("image/user/" . session('userInfo')['avatar']), session('userInfo')['fullname'],'Logout');
        if (session('userInfo')['level'] == 'admin') {
            $xhtmlMenu      .= sprintf('<li><a href="%s" target="_blank">Admin Panel</a></li>', route('dashboard'));
        }
    } else {
        $xhtmlUser  = sprintf('<a href="%s"><i class="fa %s"></i> %s</a>', route('auth/login'), 'fa-user', 'Login');
    };

@endphp

<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="img/logo.png" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            {{-- <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li> --}}
            <li><a href="{{ route('cart') }}"><i class="fa fa-shopping-bag"></i> <span>{{ Cart::content()->count() }}</span></a></li>
        </ul>
        <div class="header__cart__price">item: <span>${{ Cart::subtotal() }}</span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__language">
            <img src="{{ asset('img/language.png') }}" alt="">
            <div>English</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">Spanis</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div>
        <div class="header__top__right__auth">
            {{-- <a href="#"><i class="fa fa-user"></i> Login</a> --}}
            {!! $xhtmlUser !!}
        </div>
    </div>
    {{-- <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('store') }}">Shop</a></li>
            <li><a href="#">Blog</a>
                <ul class="header__menu__dropdown">
                    <li><a href="{{ route('blog') }}">Shop Details</a></li>
                    <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                    <li><a href="./checkout.html">Check Out</a></li>
                    <li><a href="./blog-details.html">Blog Details</a></li>
                </ul>
            </li>
            <li><a href="./blog.html">Blog</a></li>
            <li><a href="./contact.html">Contact</a></li>
        </ul>
    </nav> --}}
    {!! $xhtmlMenu !!}
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <button class="share__link share__link--facebook"><i class="fa-brands fa-facebook"></i></button>
        <button class="share__link share__link--twitter"><i class="fa-brands fa-twitter"></i></button>
        <button class="share__link share__link--linkedin"><i class="fa-brands fa-linkedin"></i></button>
        <button class="share__link share__link--pinterest"><i class="fa-brands fa-pinterest-p"></i></button>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
            <li>Free Shipping for all Order of $99</li>
        </ul>
    </div>
</div>