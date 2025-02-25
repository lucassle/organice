@php
    use Illuminate\Foundation\Auth;
    $user = auth()->user();
@endphp

<div class="nav_menu">
    <nav>
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                   aria-expanded="false">
                    <img src="{{ asset('image/user/' . session('userInfo')['avatar']) }}" alt="">{{ session('userInfo')['fullname'] }}
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                        <a href="javascript:;">
                            <span class="badge bg-red pull-right">50%</span>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="{{ route('auth/logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                </ul>
            </li>
            <li><a href="{{ route('home') }}">View Site</a></li>
        </ul>
    </nav>
</div>