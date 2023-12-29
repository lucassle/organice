@php
    use Illuminate\Support\Str;
    use Gloudemans\Shoppingcart\Facades\Cart;
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
                    <h2>Shopping Cart</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if (session('cart')) --}}
                                @foreach (Cart::content()->toArray() as $item)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{ asset('image/product/' . $item['options']['thumb']) }}" alt="{{ Str::slug($item['name']) }}">
                                        <h5>{{ $item['name'] }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        ${{ number_format($item['price'], 2, '.', '') }}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input name="quantities" value="{{ $item['qty'] }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        ${{ $item['subtotal'] }}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <a href=""><span class="icon_close"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                            {{-- @endif --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="{{ route('store') }}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                        Upadate Cart</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Discount Codes</h5>
                        <form id="coupon-id" name="coupon" action="{{ route('cart/discount') }}" method="post">
                            <input type="text" placeholder="Enter your coupon code" id="coupon-input">
                            <button type="submit" id="coupon-btn" class="site-btn">APPLY COUPON</button>
                            {{-- <input type="button" id="check" value="check"> --}}
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" id="cart-totalpmy">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        {{-- @php
                        $subtotal           = 0;
                        $cart               = session('cart');
                        if ($cart) {
                            foreach ($cart as $key => $value) {
                                $subtotal   = $value['total'];
                                if (count($cart) > 1) {
                                    $subtotal   = number_format(array_sum(array_column($cart, 'total')), 2, '.', '');
                                }
                            }
                        }
                        @endphp --}}
                        <li>Subtotal <span>${{ Cart::subtotal(); }}</span></li>
                        <li>Tax <span>${{ Cart::tax(); }}</span></li>
                        <li>Total <span>${{ Cart::total(); }}</span></li>
                    </ul>
                    <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->


@endsection