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

                <form action="shop">

                    <div class="filter-widget">
                        <h4 class="fw-title">Categories</h4>
                        <ul class="filter-catagories">

                            @foreach ($categories as $category)
                            <li><a href="shop/category/{{ $category->name }}">{{ $category->name }}</a></li>
                            @endforeach
                            
                            
                    </div>
                    <div class="filter-widget">
                        <h4 class="fw-title">Brand</h4>
                        <div class="fw-brand-check">

                            @foreach ($brands as $brand)
                            <div class="bc-item">
                                <label for="bc-{{ $brand->id }}">
                                    {{ $brand->name }}
                                    <input type="checkbox" 
                                        {{ (request("brand")[$brand->id] ?? '') == 'on' ? 'checked' : '' }}
                                        id="bc-{{ $brand->id }}"
                                        name="brand[{{ $brand->id }}]"
                                    onchange="this.form.submit();">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @endforeach
                            
                        
                        </div>

                    </div>
                   
                    <div class="filter-widget">
                    <h4 class="fw-title">Price</h4>

                    <div class="filter-range-wrap">
                        <div class="range-slider">
                            <div class="price-input">

                                <input 
                                    type="text" 
                                    id="minamount" 
                                    name="price_min"
                                    value="{{ request('price_min') ?? 10 }}"
                                >

                                <input 
                                    type="text" 
                                    id="maxamount" 
                                    name="price_max"
                                    value="{{ request('price_max') ?? 999 }}"
                                >
                            </div>
                        </div>

                        <div 
                            class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                            data-min="10"
                            data-max="999"
                            data-min-value="{{ (int) str_replace('$', '', request('price_min')) }}"
                            data-max-value="{{ (int) str_replace('$', '', request('price_max')) }}"
                            >
                            <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                        </div>
                    </div>

                    <button type="submit" class="filter-btn">Filter</button>
                </div>

                    <div class="filter-widget">
                        <h4 class="fw-title">Color</h4>
                        <div class="fw-color-choose">
                            <div class="cs-item">
                                <input type="radio" id="cs-black" name="color" value="black" onchange="this.form.submit();"
                                       {{ request('color') == 'black' ? 'checked' : '' }}>
                                <label class="cs-black {{ request('color') == 'black' ? 'font-weight-bold' : '' }}" for="cs-black">Black</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-violet" name="color" value="violet" onchange="this.form.submit();"
                                       {{ request('color') == 'violet' ? 'checked' : '' }}>
                                <label class="cs-violet {{ request('color') == 'violet' ? 'font-weight-bold' : '' }}" for="cs-violet">Violet</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-blue" name="color" value="blue" onchange="this.form.submit();"
                                       {{ request('color') == 'blue' ? 'checked' : '' }}>
                                <label class="cs-blue {{ request('color') == 'blue' ? 'font-weight-bold' : '' }}" for="cs-blue">Blue</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-yellow" name="color" value="yellow" onchange="this.form.submit();"
                                       {{ request('color') == 'yellow' ? 'checked' : '' }}>
                                <label class="cs-yellow {{ request('color') == 'yellow' ? 'font-weight-bold' : '' }}" for="cs-yellow">Yellow</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-red" name="color" value="red" onchange="this.form.submit();"
                                       {{ request('color') == 'red' ? 'checked' : '' }}>
                                <label class="cs-red {{ request('color') == 'red' ? 'font-weight-bold' : '' }}" for="cs-red">Red</label>
                            </div>
                            <div class="cs-item">
                                <input type="radio" id="cs-green" name="color" value="green" onchange="this.form.submit();"
                                       {{ request('color') == 'green' ? 'checked' : '' }}>
                                <label class="cs-green {{ request('color') == 'green' ? 'font-weight-bold' : '' }}" for="cs-green">Green</label>
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
                </form>

            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="product-show-option">
                    <div class="row">
                        <div class="col-lg-7 col-md-7">

                            <form action="">
                            <div class="select-option">
                                <select name="sort_by" onchange="this.form.submit();" class="sorting">
                                    <option {{ request('sort_by') == 'latest' ? 'selected' : ''}} value="latest">Sorting: Latest</option>
                                    <option {{ request('sort_by') == 'oldest' ? 'selected' : ''}} value="oldest">Sorting: oldest</option>
                                    <option {{ request('sort_by') == 'name-ascending' ? 'selected' : ''}} value="name-ascending">Sorting: Name A-Z</option>
                                    <option {{ request('sort_by') == 'name-descending' ? 'selected' : ''}} value="name-descending">Sorting: Name Z-A</option>
                                    <option {{ request('sort_by') == 'price-ascending' ? 'selected' : ''}} value="price-ascending">Sorting: Price Ascending</option>
                                    <option {{ request('sort_by') == 'price-descending' ? 'selected' : ''}} value="price-descending">Sorting: Price Descending</option>
                                </select>
                                <select name="show" onchange="this.form.submit();" class="p-show">
                                    <option {{ request('show') == '3' ? 'selected' : ''}} value="3">Show: 3</option>
                                   <option {{ request('show') == '9' ? 'selected' : ''}} value="9">Show: 9</option>
                                   <option {{ request('show') == '15' ? 'selected' : ''}} value="15">Show: 15</option>
                                </select>
                            </div>
                            </form>



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