<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="{{ route('dashboard') }}" class="site_title"><img src="{{ asset("shop/img/logo.png") }}" alt="logo"></a>
    </div>
    <div class="clearfix"></div>
    <!-- menu profile quick info -->
    <div class="profile clearfix">
        <div class="profile_pic">
            <img src="{{ asset('image/user/' . session('userInfo')['avatar']) }}" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
            <span>Welcome,</span>
            <h2>{{ session('userInfo')['fullname'] }}</h2>
        </div>
    </div>
    <!-- /menu profile quick info -->
    <br/>
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>General</h3>
            <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Dashboard <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('dashboard') }}"><i class="fa fa-house"></i> Home</a></li>
                        <li><a href="{{ route('logs') }}"><i class="fa fa-exclamation"></i> Logs Viewer</a></li>
                        <li><a href="{{ route('menu') }}"><i class="fa fa-bars"></i> Menu</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-user"></i> User Manager <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('user') }}"><i class="fa fa-user"></i> User</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-lemon"></i> Product Manager <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('banner') }}"><i class="fa fa-sliders"></i> Banner</a></li>
                        <li><a href="{{ route('product') }}"><i class="fa fa-lemon"></i> Product</a></li>
                        <li><a href="{{ route('attribute') }}"><i class="fa fa-file-pen"></i> Attribute</a></li>
                        <li><a href="{{ route('categoryProduct') }}"><i class="fa fa-folder-open"></i> Category Product</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-lemon"></i> Sales Manager <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('coupon') }}"><i class="fa fa-ticket"></i> Coupon</a></li>
                        <li><a href="{{ route('shippingCost') }}"><i class="fa fa-truck"></i> Shipping Cost</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-blog"></i> Blog Manager <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('article') }}"><i class="fa fa-blog"></i> Article</a></li>
                        <li><a href="{{ route('categoryArticle') }}"><i class="fa fa-folder-open"></i> Category Article</a></li>
                    </ul>
                </li>
                <li><a><i class="fa fa-phone"></i> Contact Manager <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('recall') }}"><i class="fa fa-phone"></i> Recall Request</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fa fa-address-book"></i> Contact</a></li>
                    </ul>
                </li>
            </ul>
            <br>
            <h3>Config</h3>
            <ul class="nav side-menu">
                <li><a href="{{ route('gallery') }}"><i class="fa fa-image"></i> Gallery</a></li>
                <li><a href="{{ route('password') }}"><i class="fa fa-key"></i></i> Change Password</a></li>
                <li><a href="{{ route('setting') }}"><i class="fa fa-gear"></i></i> Setting</a></li>
            </ul>
        </div>
    </div>
</div>