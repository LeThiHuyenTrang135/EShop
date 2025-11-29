@extends('front.layout.master')

@section('title', 'Cart')


@section('body')

<!-- -->
<!-- Breadcrumb section begin-->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text"> <!--phan duong dan trang-->
                    <a href="index.html"><i class="fa fa-home"></i> Home</a>
                    <a href="shop.html"><i class="fa fa-shop"></i> Shop</a>
                    <span>shopping Cart</span>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Breadcrumb section end-->


<!-- Shopping cart section begin-->
<div class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cart-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th class="p-name">Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th><i class="ti-close"></i></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($carts as $cart)
                            <tr data-rowId="{{ $cart->rowId }}">
                                <td class="cart-pic first-row">
                                    <img style="height: 170px;" src="front/img/products/{{ $cart->options->images }}" alt="">
                                </td>
                                <td class="cart-title">
                                    <h5>{{ $cart->name }}</h5>
                                </td>
                                <td class="p-price first-row">${{ number_format($cart->price, 2) }}</td>
                                <td class="qua-col first-row">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="{{ $cart->qty }}">
                                        </div>
                                    </div>
                                </td>
                                <td class="total-price first-row">${{ number_format($cart->price * $cart->qty, 2) }}</td>
                                <td class="close-td first-row">
                                    <i onclick="removeCart('{{ $cart->rowId }}')" class="ti-close"></i>
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="cart-buttons">
                            <a href="#" class="primary-btn continue-shop">continue shopping</a>
                            <a href="#" class="primary-btn up-cart">update cart</a>
                        </div>
                        <div class="discount-coupon">
                            <h6>Discount Codes</h6>
                            <form action="#" class="coupon-form">
                                <input type="text" placeholder="Enter your codes">
                                <button type="submit" class="site-btn coupon-btn">Apply</button>
                            </form>

                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-4">
                        <div class="proceed-checkout">
                            <ul>
                                <li class="subtotal">Subtotal <span>${{ $total }}</span></li>
                                <li class="cart-total">Total <span>${{ $subtotal }}</span></li>
                            </ul>
                            <a href="check-out.html" class="proceed-btn">PROCEED TO CHECK OUT</a>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shopping cart section end-->
@endsection