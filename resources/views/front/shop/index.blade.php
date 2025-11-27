@extends('front.layout.master')

@section('title', 'Shop')


@section('body')
<!--Thân -->

<!-- Breadcrumb section begin-->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text"> <!--phan duong dan trang-->
                    <a href="index.html"><i class="fa fa-home"></i> Home</a>
                    <span>Shop</span>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- Breadcrumb section End-->


<!-- Product Shop Section Begin-->
<section class="product-shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                <div class="filter-widget">
                    <h4 class="fw-title">Categories</h4>
                    <ul class="filter-catagories">
                        <li><a href="#">Men</a></li>
                        <li><a href="#">Women</a></li>
                        <li><a href="#">Kid</a></li>
                </div>
                <div class="filter-widget">
                    <h4 class="fw-title">Brand</h4>
                    <div class="fw-brand-check">
                        <div class="bc-item">
                            <label for="bc-calvin">
                                Calvin Klein
                                <input type="checkbox" id="bc-calvin">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="bc-item">
                            <label for="bc-diesel">
                                Diesel
                                <input type="checkbox" id="bc-diesel">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="bc-item">
                            <label for="bc-polo">
                                Polo
                                <input type="checkbox" id="bc-polo">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="bc-item">
                            <label for="bc-tommy">
                                Tommy Hilfiger
                                <input type="checkbox" id="bc-tommy">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="filter-widget">
                    <h4 class="fw-title">Price</h4>
                    <div class="filter-range-wrap">
                        <div class="range-slider">
                            <div class="price-input">
                                <input type="text" id="minamount">
                                <input type="text" id="maxamount">
                            </div>
                        </div>
                        <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="33" data-max="98">
                            <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                        </div>
                    </div>
                    <a href="#" class="filter-btn">Filter</a>
                </div>
                <div class="filter-widget">
                    <h4 class="fw-title">Color</h4>
                    <div class="fw-color-choose">
                        <div class="cs-item">
                            <input type="radio" id="cs-black">
                            <label class="cs-black" for="cs-black">Black</label>
                        </div>
                        <div class="cs-item">
                            <input type="radio" id="cs-violet">
                            <label class="cs-violet" for="cs-violet">Violet</label>
                        </div>
                        <div class="cs-item">
                            <input type="radio" id="cs-blue">
                            <label class="cs-blue" for="cs-blue">Blue</label>
                        </div>
                        <div class="cs-item">
                            <input type="radio" id="cs-yellow">
                            <label class="cs-yellow" for="cs-yellow">Yellow</label>
                        </div>
                        <div class="cs-item">
                            <input type="radio" id="cs-red">
                            <label class="cs-red" for="cs-red">Red</label>
                        </div>
                        <div class="cs-item">
                            <input type="radio" id="cs-green">
                            <label class="cs-green" for="cs-green">Green</label>
                        </div>
                    </div>
                </div>
                <div class="filter-widget">
                    <h4 class="fw-title">Size</h4>
                    <div class="fw-size-choose">
                        <div class="sc-item">
                            <input type="radio" id="s-size">
                            <label for="s-size">s</label>
                        </div>
                        <div class="sc-item">
                            <input type="radio" id="m-size">
                            <label for="m-size">m</label>
                        </div>
                        <div class="sc-item">
                            <input type="radio" id="l-size">
                            <label for="l-size">l</label>
                        </div>
                        <div class="sc-item">
                            <input type="radio" id="xl-size">
                            <label for="xl-size">XL</label>
                        </div>
                    </div>
                </div>
                <div class="filter-widget">
                    <h4 class="fw-title">Tags</h4>
                    <div class="fw-tags">
                        <a href="#">Towel</a>
                        <a href="#">Shoes</a>
                        <a href="#">Jumpsuit</a>
                        <a href="#">Dresses</a>
                        <a href="#">Coats</a>
                        <a href="#">Blazers</a>
                        <a href="#">Sunglasses</a>
                        <a href="#">Pants</a>
                        <a href="#">Frocks</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="product-show-option">
                    <div class="row">
                        <div class="col-lg-7 col-md-7">
                            <div class="select-option">
                                <select class="sorting">
                                    <option value="">Default Sorting</option>
                                    <option value="">Sort by Price</option>
                                    <option value="">Sort by Popularity</option>
                                    <option value="">Sort by Average Rating</option>
                                </select>
                                <select class="p-show">
                                    <option value="">Show:</option>
                                    <option value="">4</option>
                                    <option value="">8</option>
                                    <option value="">12</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 text-right">
                            
                        </div>
                    </div>

                </div>
                <div class="product-list">
                    <div class="row">

                        @foreach ($products as $product)
                        <div class="col-lg-4 col-sm-6">
                            <div class="product-item">
                                <div class="pi-pic">
                                    <img src="front/img/products/{{ $product->productImages[0]->path }}" alt="">

                                    @if($product->discount != null)
                                    <div class="sale pp-sale">Sale</div>
                                    @endif

                                    <div class="icon">
                                        <i class="icon_heart_alt"></i>
                                    </div>

                                    <ul>
                                        <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                        <li class="quick-view"><a href="shop/product/{{ $product->id }}">+ Quick View</a></li>
                                        <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
                                    </ul>
                                </div>
                                <div class="pi-text">
                                    <div class="catagory-name">{{ $product->tag }}</div>
                                    <a href="shop/product/{{ $product->id }}">
                                        <h5>{{ $product->name }}</h5>
                                    </a>
                                    <div class="product-price">
                                        @if($product->discount != null)
                                        ${{ $product->discount }}
                                        <span>${{ $product->price }}</span>
                                        @else
                                        ${{ $product->price }}
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach


                    </div>

                </div>
               {{ $products->links() }}

            </div>
        </div>

</section>
<!-- Product Shop Section End-->

@endsection