@php
    use Gloudemans\Shoppingcart\Facades\Cart;
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template;

    echo '<pre style="color: red;">';
    print_r(Cart::content()->toArray());
    echo '</pre>';
    $inputHiddenID      = Form::hidden('id', '');
    // $inputHiddenID      = Form::hidden('id', $items['id']);
    $elements   = [
        [
            'label'     => Form::label('fullname', 'Full Name'),
            'element'   => Form::text('fullname', '')
        ],
        [
            'label'     => Form::label('country', 'Country'),
            'element'   => Form::text('country', '', ['placeholder' => 'Choose from dropdown list'])
        ],
        [
            'label'     => Form::label('address', 'Address'),
            'element'   => Form::text('address', '')
        ],
        [
            'label'     => Form::label('phone', 'Phone Number'),
            'element'   => Form::text('phone', '')
        ],
        [
            'label'     => Form::label('email', 'Email'),
            'element'   => Form::text('email', '')
        ],
        [
            'label'     => Form::label('note', 'Note'),
            'element'   => Form::text('note', '')
        ],
        [
            'element'   => $inputHiddenID . Form::submit('CHECKOUT', ['class' => 'btn btn-success']),
            'type'      => "btn-submit"
        ]
    ];
@endphp

@extends('shop.main')
@section('content')
@include('shop.block.hero', ['pageIndex' => true])

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('shop/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Checkout</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Billing Details</h4>
            @include('shop.templates.success_notify')
            {!! Form::open([
                'id'        => 'form1',
                'url'       => route("$controllerName/checkout"),
                'class'     => 'form-horizontal form-label-left',
                'enctype'   => 'multipart/form-data'
            ]) !!}
                {!! FormTemplate::showCheckout($elements) !!}
            {!! Form::close() !!}
            {{-- <form action="#" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Fist Name<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Last Name<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Country<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input type="text" placeholder="Street Address" class="checkout__input__add">
                            <input type="text" placeholder="Apartment, suite, unite ect (optinal)">
                        </div>
                        <div class="checkout__input">
                            <p>Town/City<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Country/State<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Postcode / ZIP<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input__checkbox">
                            <label for="acc">
                                Create an account?
                                <input type="checkbox" id="acc">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="checkout__input">
                            <p>Order notes<span>*</span></p>
                            <input type="text"
                                placeholder="Notes about your order, e.g. special notes for delivery.">
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            @if (!empty(Cart::content()))
                                <ul>
                                    @foreach (Cart::content()->toArray() as $item)
                                        <li>{{ $item['name'] }} x {{ $item['qty'] }}<span>${{ $item['subtotal'] }}</span></li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="checkout__order__subtotal">Subtotal <span>${{ Cart::subtotal() }}</span></div>
                            <div class="checkout__order__tax">Tax <span>${{ Cart::tax() }}</span></div>
                            <div class="checkout__order__total">Total <span>${{ Cart::total() }}</span></div>
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Check Payment
                                    <input type="checkbox" id="payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="checkbox" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @if (!empty(Cart::content()))
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form> --}}
        </div>
    </div>
</section>
<!-- Checkout Section End -->

@endsection