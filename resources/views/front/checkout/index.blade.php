@extends('front.layout.master')

@section('title', 'Check Out')


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
                        <span>Check Out</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Breadcrumb section end-->


    <!-- Shopping cart section begin-->
     <div class="checkout-section spad">
        <div class="container">
            <form action="#" class="checkout-form">
                <div class="row">   
                    <div class="col-lg-6">
                        <div class="checkout-content">
                            <a href="login.html" class="content-btn">Click here to login</a>
                        </div>
                        <h4>Billing Details</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="fir">First Name<span>*</span></label>
                                <input type="text" id="fir">
                            </div>
                            <div class="col-lg-6">
                                <label for="last">Last Name<span>*</span></label>
                                <input type="text" id="last">
                            </div>
                            <div class="col-lg-12">
                                <label for="cun-name">Company Name</label>
                                <input type="text" id="cun-name">
                            </div>
                            <div class="col-lg-12">
                                <label for="cun">Country<span>*</span></label>
                                <input type="text" id="cun">
                            </div>
                            <div class="col-lg-12">
                                <label for="street">Street Address<span>*</span></label>
                                <input type="text" id="street" class="street-first">
                                <input type="text">
                            </div>
                            <div class="col-lg-6">
                                <label for="zip">Postcode / ZIP<span>*</span></label>
                                <input type="text" id="zip">
                            </div>
                            <div class="col-lg-12">
                                <label for="town">Town / City<span>*</span></label>
                                <input type="text" id="town">
                            </div>
                            <div class="col-lg-6">
                                <label for="phone">Phone<span>*</span></label>
                                <input type="text" id="phone">
                            </div>
                            <div class="col-lg-12">
                                <label for="email">Email Address<span>*</span></label>
                                <input type="text" id="email">
                            </div>
                            <div class="col-lg-12">
                                <div class="create-item">
                                    <label for="acc-create">
                                        Create an account?
                                        <input type="checkbox" id="acc-create">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="checkout-content">
                            <input type="text" placeholder="Enter your coupon code">

                        </div>
                        <div class="place-order">
                            <h4>Your Order</h4>
                            <div class="order-total">
                                <ul class="order-table">
                                    <li>Product <span>Total</span></li>

                                    @foreach ($carts as $cart)
                                    <li class="fw-normal">
                                        {{ $cart->name }} x {{ $cart->qty }}
                                        <span>${{ $cart->price * $cart->qty }}</span>
                                    </li>
                                    @endforeach
                                    

                                    <li class="fw-normal">Subtotal<span>${{ $subtotal }}</span></li>
                                    <li class="total-price">Total <span>${{ $total }}</span></li>
                                </ul>
                                <div class="payment-check">
                                    <div class="pc-item">
                                        <label for="pc-check">
                                            Check Payment
                                            <input type="checkbox" id="pc-check">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="pc-item">
                                        <label for="pc-paypal">
                                            Paypal
                                            <input type="checkbox" id="pc-paypal">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                                <div class="order-btn">
                                    <button type="submit" class="site-btn place-btn">Place Order</button>
                                </div>
                                  

                            </div>

                        </div>
                    </div>
                </div>
            </form>    
        </div>

     </div>
  <!-- Shopping cart section end-->
@endsection
