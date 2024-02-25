@php
    use App\Helpers\URL;
    use App\Helpers\Form as FormTemplate;

    $pageHero       = sprintf('<section class="hero">');
    if ($pageIndex == true) {
        $pageHero   = sprintf('<section class="hero hero-normal">');
    }
    
    $xhtmlCategory  = '';
    if (!empty($itemCategory)) {
        foreach ($itemCategory as $value) {
            $linkCategory   = URL::linkCategoryProduct($value['id'], $value['name']);
            $xhtmlCategory  .= sprintf('<li><a href="%s">%s</a></li>', $linkCategory, $value['name']);
        }
    }
    
@endphp

{{-- <div id="myModal" class="modal fade zvn-modal in" role="dialog" style="display: block; padding-right: 17px;">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Contact Us</h4>
            </div>
            <div class="modal-body ">
                <img src="{{ asset('shop/img/logo.png') }}" alt="logo.png">
                <p>Need Help? &amp; booking now!</p>
                <a href="tel:+65 11.188.888" class="thm-btn zvn-chat"><i class="fa fa-phone" aria-hidden="true"></i></a>
                <p>Or leave your number here</p>
                <input type="text" name="phone_customer" placeholder="Your phonenumber">
                <a href="javascript::void()" class="thm-btn zvn-call zvn-submit-phone"> Recall Request</a>

            </div>

        </div>

    </div>
</div> --}}

{!! $pageHero !!}
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All departments</span>
                    </div>
                    <ul>
                        {!! $xhtmlCategory !!}
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="What do you need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <a href="javascript::void()" data-toggle="modal" data-target="#myModal" id="myImg" class="thm-btn zvn-call hidden-sm hidden-xs"><i class="fa fa-phone" aria-hidden="true"></i></a>
                            <div id="myModal" class="modal fade zvn-modal in">
                                <div class="modal-dialog">
                            
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">Contact Us</h4>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset('shop/img/logo.png') }}" alt="">
                                            <p>Call us now</p>
                                            <a href="tel:+6511188888" class="thm-btn zvn-chat"><i class="fa fa-phone" aria-hidden="true"></i> +65 11.188.888</a>
                                            <p>Or leave your phone number to receive a call from Organice</p>
                                            {{-- <form action="{{ route('home/getphone') }}" name="getphone" id="getphone" method="post">
                                                <input type="text" name="phone_customer" placeholder="Your phone number">
                                                <br>
                                                <button type="submit" id="zvn-submit-phone" class="thm-btn zvn-call">Request a callback</button>
                                                <a href="javascript::void()" class="thm-btn zvn-call zvn-submit-phone"> Request a callback</a>
                                            </form> --}}
                                            <form id="phoneNumberForm">
                                                @csrf
                                                <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Your phone number" required>
                                                <br>
                                                <button type="submit" class="thm-btn btn-call">Request a callback</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 11.188.888</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
                @if ($pageIndex == false)
                    <div class="hero__item set-bg" data-setbg="{{ asset("shop/img/hero/banner.jpg") }}">
                        <div class="hero__text">
                            <span>FRUIT FRESH</span>
                            <h2>Vegetable <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="{{ route('store') }}" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>