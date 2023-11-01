@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? ''}}
@endsection

@section('content')

    <!-- home slider section start-->
    <div class="container slider-category contain-slider">
        <div class="row">
            <div class="col-xl-9">
                <div class="full-slider">
                    <div class="slide-1 home-slider home-fix">
                        <div>
                            <div class="home text-start p-left">
                                <img src="{{asset('assets/hero/hero1.jpeg')}}" class="bg-img " alt="">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div class="slider-contain">
                                                <div>
                                                    <h5>all brands</h5>
                                                    <h1>fashion product</h1>
                                                    <h4>valid till 25 august</h4>
                                                    <a href="#" class="btn btn-solid">shop now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="home text-start p-right">
                                <img src="{{asset('assets/hero/hero2.jpeg')}}" class="bg-img " alt="">
                                <div class="container">
                                    <div class="row">
                                        <div class="col offset-xl-3">
                                            <div class="slider-contain">
                                                <div>
                                                    <h5>all brands</h5>
                                                    <h1>fashion product</h1>
                                                    <h4>valid till 25 august</h4>
                                                    <a href="#" class="btn btn-solid">shop now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="category-right">
                    <div class="cat-box">
                        <img src="{{asset('assets/hero/side-img1.jpeg')}}" alt="" class="img-fluid">
                    </div>
                    <div class="cat-box">
                        <img src="{{asset('assets/hero/side-img2.jpeg')}}" alt="" class="img-fluid">
                    </div>
                    <div class="cat-box">
                        <img src="{{asset('assets/hero/side-img3.jpeg')}}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- home slider section end-->


    <!-- service section start -->
    <section class="service-banner">
        <div class="container">
            <div class="row partition_3">
                <div class="col-lg-4">
                    <div class="service-box ">
                        <p>$15 off for order over 2000</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-box">
                        <p>cash on delivery availble</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-box">
                        <p>e-shopping card - save upto $20</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- service section end-->


    <!-- Product slider section start -->
    <section class="slider-section slider-layout-4 no-border-product">
        <div class="container">
            <div class="title-basic">
                <h2 class="title"><i class="ti-bolt"></i> flash sale</h2>
                <div class="timer-flash">
                    <div class="clock"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 p-0 ratio_asos">
                    <div class="slider-6 no-arrow">
                        @foreach($flash_sales as $index => $product)
                            <div>
                                <div class="product-box">
                                    <div class="img-block">
                                        <a href="#"><img src="{{asset('assets/images/fashion/pro/1.jpg')}}"
                                                         class=" img-fluid bg-img" alt=""></a>
                                        <div class="cart-info">
                                            <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                        class="ti-shopping-cart"></i></button>
                                            <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                    aria-hidden="true"></i></a>
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                               data-bs-target="#quick-view" title="Quick View"><i class="ti-search"
                                                                                                  aria-hidden="true"></i></a>
                                            <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                      aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-info product-content">
                                        <a href="#"><h6>{{$product->name}}</h6></a>
                                        <h5>{{$product->prices->data[0]->currency ?? 'NGN'}} {{$product->default_unit_price->formatted}}</h5>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    <h5>color</h5>
                                                    <ul class="color-variant">
                                                        <li class="light-purple active"></li>
                                                        <li class="theme-blue"></li>
                                                        <li class="theme-color"></li>
                                                    </ul>
                                                </div>
                                                <div class="size">
                                                    <h5>size</h5>
                                                    <ul class="size-box">
                                                        <li class="active">xs</li>
                                                        <li>s</li>
                                                        <li>m</li>
                                                        <li>l</li>
                                                        <li>xl</li>
                                                    </ul>
                                                </div>
                                                <div class="addtocart_btn">
                                                    {{--                                                class="add-to-cart-btn"--}}
                                                    {{--                                                <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>--}}
                                                    <a href="{{$product->id}}" class="add-to-cart-btn">add to cart</a>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-cart">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product slider section end -->


    <!-- collection banner start -->
    <section class="ratio_40">
        <div class="container">
            <div class="row partition-3">
                <div class="col-md-6">
                    <a href="#">
                        <div class="collection-banner border-0 p-right text-start">
                            <div class="img-part">
                                <img src="../assets/images/fashion/banner/banner1.jpg" class=" img-fluid  bg-img"
                                     alt="">
                            </div>
                            <div class="contain-banner">
                                <div>
                                    <div class="banner-deal">
                                        <h6>free shipping</h6>
                                    </div>
                                    <h3>nikon camera</h3>
                                    <h6>shop now</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#">
                        <div class="collection-banner border-0 p-left text-start">
                            <div class="img-part">
                                <img src="../assets/images/fashion/banner/banner2.jpg" class=" img-fluid bg-img" alt="">
                            </div>
                            <div class="contain-banner">
                                <div>
                                    <div class="banner-deal">
                                        <h6>minimum 30% off</h6>
                                    </div>
                                    <h3>kids fashion</h3>
                                    <h6>shop now</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- collection banner end -->


    <!-- Category section start -->
    <section class="category no-arrow">
        <div class="container">
            <div class="category-6">
                <div>
                    <div class="category-block">
                        <img src="../assets/images/category/fashion/dress.png" alt="">
                        <div class="category-content">
                            <h6>20% off</h6>
                            <h5>dresses</h5>
                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="category-block">
                        <img src="../assets/images/category/fashion/tops.png" alt="">
                        <div class="category-content">
                            <h6>-10% off</h6>
                            <h5>tops</h5>
                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="category-block">
                        <img src="../assets/images/category/fashion/bottoms.png" alt="">
                        <div class="category-content">
                            <h6>30% off</h6>
                            <h5>bottoms</h5>
                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="category-block">
                        <img src="../assets/images/category/fashion/heels.png" alt="">
                        <div class="category-content">
                            <h6>sale</h6>
                            <h5>heels</h5>
                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="category-block">
                        <img src="../assets/images/category/fashion/bags.png" alt="">
                        <div class="category-content">
                            <h6>-5% off</h6>
                            <h5>bags</h5>
                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="category-block">
                        <img src="../assets/images/category/fashion/swim-wear.png" alt="">
                        <div class="category-content">
                            <h6>$99</h6>
                            <h5>swim</h5>
                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="category-block">
                        <img src="../assets/images/category/fashion/accessories.png" alt="">
                        <div class="category-content">
                            <h6>$99</h6>
                            <h5>other</h5>
                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Category section end -->


    <!-- Product slider section start -->
    <section class="slider-section slider-layout-4 no-border-product">
        <div class="container">
            <div class="title-basic">
                <h2 class="title">what's new</h2>
            </div>
            <div class="row">
                <div class="col-xl-12 p-0 ratio_asos">
                    <div class="slider-6 no-arrow">
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/1.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/2.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/8.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/4.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/5.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/7.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/3.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product slider section end -->


    <!-- Product slider section start -->
    <section class="slider-section slider-layout-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 pe-0 ratio_square">
                    <div class="tab-head">
                        <h2 class="title">last chance to buy</h2>
                    </div>
                    <div class="slider-2">
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/14.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/11.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/12.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/13.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/14.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/3.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/4.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="product-box">
                                <div class="img-block">
                                    <a href="#"><img src="../assets/images/fashion/pro/6.jpg" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div class="product-info product-content">
                                    <a href="#"><h6>richard mcClintock</h6></a>
                                    <h5>$963.00</h5>
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                <h5>color</h5>
                                                <ul class="color-variant">
                                                    <li class="light-purple active"></li>
                                                    <li class="theme-blue"></li>
                                                    <li class="theme-color"></li>
                                                </ul>
                                            </div>
                                            <div class="size">
                                                <h5>size</h5>
                                                <ul class="size-box">
                                                    <li class="active">xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                            <div class="addtocart_btn">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" class="closeCartbox"
                                                   data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 side-banner side-banner2 pe-0 d-none d-xl-block">
                    <a href="#"><img src="../assets/images/vb-fashion.jpg" alt="" class=" img-fluid "></a>
                </div>
                <div class="col-xl-6 ps-0 ratio_square media-product-section">
                    <div class="tab-head">
                        <h2 class="title">editor's picks</h2>
                    </div>
                    <div class="slide-2">
                        <div>
                            <div class="media product-box">
                                <a href="" tabindex="0">
                                    <img class="img-fluid ed" src="../assets/images/fashion/pro/1.jpg" alt="">
                                </a>
                                <div class="media-body align-self-center">
                                    <a href="product-page(no-sidebar).html" tabindex="0">
                                        <h6>richard mcClintock</h6>
                                    </a>
                                    <h5>$963.00</h5>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    <h5>color</h5>
                                                    <ul class="color-variant">
                                                        <li class="light-purple active"></li>
                                                        <li class="theme-blue"></li>
                                                        <li class="theme-color"></li>
                                                    </ul>
                                                </div>
                                                <div class="size">
                                                    <h5>size</h5>
                                                    <ul class="size-box">
                                                        <li class="active">xs</li>
                                                        <li>s</li>
                                                        <li>m</li>
                                                        <li>l</li>
                                                        <li>xl</li>
                                                    </ul>
                                                </div>
                                                <div class="addtocart_btn">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add
                                                        to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-cart">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="media product-box">
                                <a href="" tabindex="0">
                                    <img class="img-fluid ed" src="../assets/images/fashion/pro/12.jpg" alt="">
                                </a>
                                <div class="media-body align-self-center">
                                    <a href="product-page(no-sidebar).html" tabindex="0">
                                        <h6>richard mcClintock</h6>
                                    </a>
                                    <h5>$963.00</h5>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    <h5>color</h5>
                                                    <ul class="color-variant">
                                                        <li class="light-purple active"></li>
                                                        <li class="theme-blue"></li>
                                                        <li class="theme-color"></li>
                                                    </ul>
                                                </div>
                                                <div class="size">
                                                    <h5>size</h5>
                                                    <ul class="size-box">
                                                        <li class="active">xs</li>
                                                        <li>s</li>
                                                        <li>m</li>
                                                        <li>l</li>
                                                        <li>xl</li>
                                                    </ul>
                                                </div>
                                                <div class="addtocart_btn">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add
                                                        to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-cart">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="media product-box">
                                <a href="" tabindex="0">
                                    <img class="img-fluid ed" src="../assets/images/fashion/pro/3.jpg" alt="">
                                </a>
                                <div class="media-body align-self-center">
                                    <a href="product-page(no-sidebar).html" tabindex="0">
                                        <h6>richard mcClintock</h6>
                                    </a>
                                    <h5>$963.00</h5>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    <h5>color</h5>
                                                    <ul class="color-variant">
                                                        <li class="light-purple active"></li>
                                                        <li class="theme-blue"></li>
                                                        <li class="theme-color"></li>
                                                    </ul>
                                                </div>
                                                <div class="size">
                                                    <h5>size</h5>
                                                    <ul class="size-box">
                                                        <li class="active">xs</li>
                                                        <li>s</li>
                                                        <li>m</li>
                                                        <li>l</li>
                                                        <li>xl</li>
                                                    </ul>
                                                </div>
                                                <div class="addtocart_btn">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add
                                                        to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-cart">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="media product-box">
                                <a href="" tabindex="0">
                                    <img class="img-fluid ed" src="../assets/images/fashion/pro/14.jpg" alt="">
                                </a>
                                <div class="media-body align-self-center">
                                    <a href="product-page(no-sidebar).html" tabindex="0">
                                        <h6>richard mcClintock</h6>
                                    </a>
                                    <h5>$963.00</h5>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    <h5>color</h5>
                                                    <ul class="color-variant">
                                                        <li class="light-purple active"></li>
                                                        <li class="theme-blue"></li>
                                                        <li class="theme-color"></li>
                                                    </ul>
                                                </div>
                                                <div class="size">
                                                    <h5>size</h5>
                                                    <ul class="size-box">
                                                        <li class="active">xs</li>
                                                        <li>s</li>
                                                        <li>m</li>
                                                        <li>l</li>
                                                        <li>xl</li>
                                                    </ul>
                                                </div>
                                                <div class="addtocart_btn">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add
                                                        to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-cart">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="media product-box">
                                <a href="" tabindex="0">
                                    <img class="img-fluid ed" src="../assets/images/fashion/pro/5.jpg" alt="">
                                </a>
                                <div class="media-body align-self-center">
                                    <a href="product-page(no-sidebar).html" tabindex="0">
                                        <h6>richard mcClintock</h6>
                                    </a>
                                    <h5>$963.00</h5>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    <h5>color</h5>
                                                    <ul class="color-variant">
                                                        <li class="light-purple active"></li>
                                                        <li class="theme-blue"></li>
                                                        <li class="theme-color"></li>
                                                    </ul>
                                                </div>
                                                <div class="size">
                                                    <h5>size</h5>
                                                    <ul class="size-box">
                                                        <li class="active">xs</li>
                                                        <li>s</li>
                                                        <li>m</li>
                                                        <li>l</li>
                                                        <li>xl</li>
                                                    </ul>
                                                </div>
                                                <div class="addtocart_btn">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add
                                                        to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-cart">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="media product-box">
                                <a href="" tabindex="0">
                                    <img class="img-fluid ed" src="../assets/images/fashion/pro/6.jpg" alt="">
                                </a>
                                <div class="media-body align-self-center">
                                    <a href="product-page(no-sidebar).html" tabindex="0">
                                        <h6>richard mcClintock</h6>
                                    </a>
                                    <h5>$963.00</h5>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    <h5>color</h5>
                                                    <ul class="color-variant">
                                                        <li class="light-purple active"></li>
                                                        <li class="theme-blue"></li>
                                                        <li class="theme-color"></li>
                                                    </ul>
                                                </div>
                                                <div class="size">
                                                    <h5>size</h5>
                                                    <ul class="size-box">
                                                        <li class="active">xs</li>
                                                        <li>s</li>
                                                        <li>m</li>
                                                        <li>l</li>
                                                        <li>xl</li>
                                                    </ul>
                                                </div>
                                                <div class="addtocart_btn">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add
                                                        to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-cart">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="media product-box">
                                <a href="" tabindex="0">
                                    <img class="img-fluid ed" src="../assets/images/fashion/pro/7.jpg" alt="">
                                </a>
                                <div class="media-body align-self-center">
                                    <a href="product-page(no-sidebar).html" tabindex="0">
                                        <h6>richard mcClintock</h6>
                                    </a>
                                    <h5>$963.00</h5>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    <h5>color</h5>
                                                    <ul class="color-variant">
                                                        <li class="light-purple active"></li>
                                                        <li class="theme-blue"></li>
                                                        <li class="theme-color"></li>
                                                    </ul>
                                                </div>
                                                <div class="size">
                                                    <h5>size</h5>
                                                    <ul class="size-box">
                                                        <li class="active">xs</li>
                                                        <li>s</li>
                                                        <li>m</li>
                                                        <li>l</li>
                                                        <li>xl</li>
                                                    </ul>
                                                </div>
                                                <div class="addtocart_btn">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add
                                                        to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-cart">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="media product-box">
                                <a href="" tabindex="0">
                                    <img class="img-fluid ed" src="../assets/images/fashion/pro/8.jpg" alt="">
                                </a>
                                <div class="media-body align-self-center">
                                    <a href="product-page(no-sidebar).html" tabindex="0">
                                        <h6>richard mcClintock</h6>
                                    </a>
                                    <h5>$963.00</h5>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    <h5>color</h5>
                                                    <ul class="color-variant">
                                                        <li class="light-purple active"></li>
                                                        <li class="theme-blue"></li>
                                                        <li class="theme-color"></li>
                                                    </ul>
                                                </div>
                                                <div class="size">
                                                    <h5>size</h5>
                                                    <ul class="size-box">
                                                        <li class="active">xs</li>
                                                        <li>s</li>
                                                        <li>m</li>
                                                        <li>l</li>
                                                        <li>xl</li>
                                                    </ul>
                                                </div>
                                                <div class="addtocart_btn">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add
                                                        to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-cart">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="media product-box">
                                <a href="" tabindex="0">
                                    <img class="img-fluid ed" src="../assets/images/fashion/pro/10.jpg" alt="">
                                </a>
                                <div class="media-body align-self-center">
                                    <a href="product-page(no-sidebar).html" tabindex="0">
                                        <h6>richard mcClintock</h6>
                                    </a>
                                    <h5>$963.00</h5>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart"
                                                                                                aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"
                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                        <a href="compare.html" title="Compare"><i class="ti-reload"
                                                                                  aria-hidden="true"></i></a>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    <h5>color</h5>
                                                    <ul class="color-variant">
                                                        <li class="light-purple active"></li>
                                                        <li class="theme-blue"></li>
                                                        <li class="theme-color"></li>
                                                    </ul>
                                                </div>
                                                <div class="size">
                                                    <h5>size</h5>
                                                    <ul class="size-box">
                                                        <li class="active">xs</li>
                                                        <li>s</li>
                                                        <li>m</li>
                                                        <li>l</li>
                                                        <li>xl</li>
                                                    </ul>
                                                </div>
                                                <div class="addtocart_btn">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add
                                                        to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-cart">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product slider section end -->


    <!-- blog section start -->
    <section class=" p-t-0  blog-section">
        <div class="container">
            <h2 class="title pt-0">from the blog</h2>
            <div class="slide-4">
                <div>
                    <a href="#" class="blog">
                        <div class="blog-image">
                            <img src="../assets/images/fashion/blog/1.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="blog-info">
                            <div>
                                <h5>25 july 2018</h5>
                                <p>Sometimes on purpose ected humour. dummy text.</p>
                                <h6>by: admin, 0 comment</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="#" class="blog">
                        <div class="blog-image">
                            <img src="../assets/images/fashion/blog/2.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="blog-info">
                            <div>
                                <h5>25 july 2018</h5>
                                <p>Sometimes on purpose ected humour. dummy text.</p>
                                <h6>by: admin, 0 comment</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="#" class="blog">
                        <div class="blog-image">
                            <img src="../assets/images/fashion/blog/5.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="blog-info">
                            <div>
                                <h5>25 july 2018</h5>
                                <p>Sometimes on purpose ected humour. dummy text.</p>
                                <h6>by: admin, 0 comment</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="#" class="blog">
                        <div class="blog-image">
                            <img src="../assets/images/fashion/blog/4.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="blog-info">
                            <div>
                                <h5>25 july 2018</h5>
                                <p>Sometimes on purpose ected humour. dummy text.</p>
                                <h6>by: admin, 0 comment</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="#" class="blog">
                        <div class="blog-image">
                            <img src="../assets/images/fashion/blog/3.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="blog-info">
                            <div>
                                <h5>25 july 2018</h5>
                                <p>Sometimes on purpose ected humour. dummy text.</p>
                                <h6>by: admin, 0 comment</h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- blog secion end -->


    <!-- section start -->
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 logo no-border">
                    <h2 class="title">trusted brand</h2>
                    <div class="logo-3 border-logo">
                        <div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/1.png" class=" img-fluid" alt="">
                            </div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/2.png" class=" img-fluid" alt="">
                            </div>
                        </div>
                        <div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/3.png" class=" img-fluid" alt="">
                            </div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/4.png" class=" img-fluid" alt="">
                            </div>
                        </div>
                        <div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/5.png" class=" img-fluid" alt="">
                            </div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/6.png" class=" img-fluid" alt="">
                            </div>
                        </div>
                        <div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/7.png" class=" img-fluid" alt="">
                            </div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/8.png" class=" img-fluid" alt="">
                            </div>
                        </div>
                        <div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/2.png" class=" img-fluid" alt="">
                            </div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/3.png" class=" img-fluid" alt="">
                            </div>
                        </div>
                        <div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/2.png" class=" img-fluid" alt="">
                            </div>
                            <div class="logo-img">
                                <img src="../assets/images/logo/3.png" class=" img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 offset-xl-1">
                    <div class="app-section">
                        <div class="img-block">
                            <img src="{{asset('assets/hero/mobile.jpeg')}}"class=" img-fluid" alt="">
                        </div>
                        <div class="app-content">
                            <div>
                                <h5>download the big market app</h5>
                                <div class="app-buttons">
                                    <a href="#"><img src="../assets/images/app/app-storw.png" class=" img-fluid" alt=""></a>
                                    <a href="#"><img src="../assets/images/app/play-store.png" class=" img-fluid"
                                                     alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->

@endsection
