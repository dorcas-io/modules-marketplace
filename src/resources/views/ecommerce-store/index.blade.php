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
                                <img src="{{asset($main_banner1)}}" class="bg-img " alt="">
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
                                <img src="{{asset($main_banner2)}}" class="bg-img " alt="">
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
                        <img src="{{asset($sideBanner1)}}" alt="" class="img-fluid">
                    </div>
                    <div class="cat-box">
                        <img src="{{asset($sideBanner2)}}" alt="" class="img-fluid">
                    </div>
                    <div class="cat-box">
                        <img src="{{asset($sideBanner3)}}" alt="" class="img-fluid">
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
                <h2 class="title"><i class="ti-bolt"></i> {{$topSidePromo}}</h2>
                @if($counter)
                <div class="timer-flash">
                    <div class="clock"></div>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-xl-12 p-0 ratio_asos">
                    <div class="slider-6 no-arrow">
                        @foreach($topSideProducts as $index => $product)
                            <div>
                                <div class="product-box">
                                    <div class="img-block" style="position:relative;">
                                        <a href="{{url('/product/'.$product->id .'?promotions='.$topSidePromo)}}">
                                            <img src="{{ isset($product->product_images[0]) ? asset($product->product_images[0]->url) : asset('assets/images/fashion/pro/1.jpg')}}"
                                                         class=" img-fluid bg-img" alt=""></a>
                                        <div class="cart-info">
                                            <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                        class="ti-shopping-cart"></i></button>
{{--                                            <a href="{{$product->id}}" title="Add to Wishlist" class="add-to-wishlist"><i class="ti-heart"--}}
{{--                                                                                                    aria-hidden="true"></i></a>--}}
{{--                                            <a href="javascript:void(0)" data-bs-toggle="modal"--}}
{{--                                               data-bs-target="#quick-view" title="Quick View"><i class="ti-search"--}}
{{--                                                                                                  aria-hidden="true"></i></a>--}}
                                            <a href="{{url('/product/'.$product->id.'?promotions='.$topSidePromo)}}"  title="View"><i class="ti-eye"
                                                                                      aria-hidden="true"></i></a>
                                        </div>
                                        @if($product->has_discount === '1')
                                        <span style="position: absolute;top:8%; left: 5%; background : var(--company-primary-color); padding:2%;color:#fff; border-radius: 10%; "> - {{$product->discount_value}}% </span>
                                        @endif
                                    </div>
                                    <div class="product-info product-content">
                                        <a href="{{url('/product/'.$product->id.'?promotions='.$topSidePromo)}}"><h6>{{$product->name}}</h6></a>
                                        @php
                                               $discountedAmount = 0;
                                               if($product->has_discount === '1'){
                                                $caclDiscount =   $product->discount_value/100 * $product->prices->data[0]->unit_price->raw;
                                                $discountedAmount = $product->prices->data[0]->unit_price->raw -  $caclDiscount  ;
                                               }
                                        @endphp
                                        @if($product->has_discount === '1')

                                        <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $discountedAmount  :0}} <br> <del><span>  {{$product->prices->data[0]->currency ?? 'NGN'}} {{  $product->prices->data[0]->unit_price->formatted  ?? 0}} </span></del> </h5>
                                        @else
                                            <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $product->prices->data[0]->unit_price->formatted :0}} </h5>
                                        @endif
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div>
                                                <div class="color">
                                                    @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'colour')
                                                        <h5>color</h5>
                                                    @endif
                                                    <ul class="color-variant">
                                                    @foreach($product->variants as $variant)
                                                        @if(strtolower($variant->product_variant_type) === 'colour')
                                                             <li class="{{$variant->product_variant}}"></li>
                                                        @endif
                                                    @endforeach
                                                    </ul>
                                                </div>

                                                <div class="size">
                                                    @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'size')
                                                        <h5>size</h5>
                                                    @endif
                                                    <ul class="size-box">
                                                        @foreach($product->variants as $variant)
                                                            @if(strtolower($variant->product_variant_type) === 'size')
                                                                <li class="{{$variant->product_variant}}"></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>

                                                <div class="addtocart_btn">
                                                    {{--                                                class="add-to-cart-btn"--}}
                                                    {{--                                                <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>--}}
                                                    <a href="{{$product->id.'?promo_name='.$topSidePromo}}" class="add-to-cart-btn">add to cart</a>

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
                                <img src="{{asset($midBannersLeft)}}" class=" img-fluid  bg-img"
                                     alt="">
                            </div>
                            <div class="contain-banner">
                                <div>
{{--                                    <div class="banner-deal">--}}
{{--                                        <h6>free shipping</h6>--}}
{{--                                    </div>--}}
{{--                                    <h3>nikon camera</h3>--}}
{{--                                    <h6>shop now</h6>--}}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#">
                        <div class="collection-banner border-0 p-left text-start">
                            <div class="img-part">
                                <img src="{{asset($midBannersRight)}}" class=" img-fluid bg-img" alt="">
                            </div>
                            <div class="contain-banner">
                                <div>
{{--                                    <div class="banner-deal">--}}
{{--                                        <h6>minimum 30% off</h6>--}}
{{--                                    </div>--}}
{{--                                    <h3>kids fashion</h3>--}}
{{--                                    <h6>shop now</h6>--}}
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
{{--    <section class="category no-arrow">--}}
{{--        <div class="container">--}}
{{--            <div class="category-6">--}}
{{--                <div>--}}
{{--                    <div class="category-block">--}}
{{--                        <img src="../assets/images/category/fashion/dress.png" alt="">--}}
{{--                        <div class="category-content">--}}
{{--                            <h6>20% off</h6>--}}
{{--                            <h5>dresses</h5>--}}
{{--                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <div class="category-block">--}}
{{--                        <img src="../assets/images/category/fashion/tops.png" alt="">--}}
{{--                        <div class="category-content">--}}
{{--                            <h6>-10% off</h6>--}}
{{--                            <h5>tops</h5>--}}
{{--                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <div class="category-block">--}}
{{--                        <img src="../assets/images/category/fashion/bottoms.png" alt="">--}}
{{--                        <div class="category-content">--}}
{{--                            <h6>30% off</h6>--}}
{{--                            <h5>bottoms</h5>--}}
{{--                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <div class="category-block">--}}
{{--                        <img src="../assets/images/category/fashion/heels.png" alt="">--}}
{{--                        <div class="category-content">--}}
{{--                            <h6>sale</h6>--}}
{{--                            <h5>heels</h5>--}}
{{--                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <div class="category-block">--}}
{{--                        <img src="../assets/images/category/fashion/bags.png" alt="">--}}
{{--                        <div class="category-content">--}}
{{--                            <h6>-5% off</h6>--}}
{{--                            <h5>bags</h5>--}}
{{--                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <div class="category-block">--}}
{{--                        <img src="../assets/images/category/fashion/swim-wear.png" alt="">--}}
{{--                        <div class="category-content">--}}
{{--                            <h6>$99</h6>--}}
{{--                            <h5>swim</h5>--}}
{{--                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <div class="category-block">--}}
{{--                        <img src="../assets/images/category/fashion/accessories.png" alt="">--}}
{{--                        <div class="category-content">--}}
{{--                            <h6>$99</h6>--}}
{{--                            <h5>other</h5>--}}
{{--                            <a href="#" class="btn btn-solid btn-solid-sm">view more</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- Category section end -->


    <!-- Product slider section start -->
    <section class="slider-section slider-layout-4 no-border-product">
        <div class="container">
            <div class="title-basic">
                <h2 class="title">{{$midSidePromo}}</h2>
            </div>
            <div class="row">
                <div class="col-xl-12 p-0 ratio_asos">
                    <div class="slider-6 no-arrow">
                        @foreach($midSideProducts as $index => $product)
                        <div>
                            <div class="product-box">
                                <div class="img-block" style="position:relative;">
                                    <a href="{{url('/product/'.$product->id.'?promotions='.$midSidePromo)}}">
                                        <img src="{{ isset($product->product_images[0]) ? asset($product->product_images[0]->url) : asset('assets/images/fashion/pro/1.jpg')}}" class=" img-fluid bg-img"
                                                     alt="">
                                    </a>
                                    <div class="cart-info">
                                     <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                        class="ti-shopping-cart"></i>
                                     </button>
{{--                                            <a href="{{$product->id}}" title="Add to Wishlist"--}}
{{--                                               class="add-to-wishlist"><i class="ti-heart" aria-hidden="true"></i>--}}
{{--                                            </a>--}}
{{--                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view"--}}
{{--                                           title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>--}}
                                        <a href="{{url('/product/'.$product->id.'?promotions='.$midSidePromo)}}"  title="View"><i class="ti-eye"
                                                                                                     aria-hidden="true"></i></a>
                                    </div>
                                    @if($product->has_discount === '1')
                                        <span style="position: absolute;top:8%; left: 5%; background : var(--company-primary-color); padding:2%;color:#fff; border-radius: 10%; "> - {{$product->discount_value}}% </span>
                                    @endif
                                </div>
                                <div class="product-info product-content">
                                    <a href="{{url('/product/'.$product->id.'?promotions='.$midSidePromo)}}"><h6>{{$product->name}}</h6></a>
                                    @php
                                        $discountedAmount = 0;

                                        if($product->has_discount === '1'){

                                         $caclDiscount =   $product->discount_value/100 * $product->prices->data[0]->unit_price->raw;

                                         $discountedAmount = $product->prices->data[0]->unit_price->raw -  $caclDiscount  ;
                                        }
                                    @endphp
                                    
                                    @if($product->has_discount === '1')
                                        <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $discountedAmount  :0}} <br> <del><span>  {{$product->prices->data[0]->currency ?? 'NGN'}} {{  $product->prices->data[0]->unit_price->formatted  ?? 0}} </span></del> </h5>
                                    @else
                                        <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $product->prices->data[0]->unit_price->formatted :0}} </h5>
                                    @endif
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div>
                                            <div class="color">
                                                @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'colour')
                                                    <h5>color</h5>
                                                @endif
                                                <ul class="color-variant">
                                                    @foreach($product->variants as $variant)
                                                        @if(strtolower($variant->product_variant_type) === 'colour')
                                                            <li class="{{$variant->product_variant}}"></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="size">
                                                @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'size')
                                                    <h5>size</h5>
                                                @endif
                                                <ul class="size-box">
                                                    @foreach($product->variants as $variant)
                                                        @if(strtolower($variant->product_variant_type) === 'size')
                                                            <li class="{{$variant->product_variant}}"></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="addtocart_btn">
                                                {{--                                                class="add-to-cart-btn"--}}
                                                {{--                                                <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>--}}
                                                <a href="{{$product->id.'?promo_name='.$midSidePromo}}" class="add-to-cart-btn">add to cart</a>

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


    <!-- Product slider section start -->
    <section class="slider-section slider-layout-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 pe-0 ratio_square">
                    <div class="tab-head">
                        <h2 class="title">{{$leftSidePromo}}</h2>
                    </div>
                    <div class="slider-2">
                        <div>
                            @foreach($leftSideProductsLeft as $index => $product)
                            <div class="product-box">
                                <div class="img-block" style="position: relative;">
                                    <a href="{{url('/product/'.$product->id.'?promotions='.$leftSidePromo)}}">
                                        <img src="{{ isset($product->product_images[0]) ? asset($product->product_images[0]->url) : asset('assets/images/fashion/pro/1.jpg')}}" class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop">
                                            <i class="ti-shopping-cart"></i>
                                        </button>
{{--                                        <a href="{{$product->id}}"--}}
{{--                                           class="add-to-wishlist" title="Add to Wishlist">--}}
{{--                                            <i class="ti-heart" aria-hidden="true"></i></a>--}}
                                        <a href="{{url('/product/'.$product->id.'?promotions='.$leftSidePromo)}}"  title="View"><i class="ti-eye"
                                                                                                     aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    @if($product->has_discount === '1')
                                        <span style="position: absolute;top:8%; left: 5%; background : var(--company-primary-color); padding:2%;color:#fff; border-radius: 10%; "> - {{$product->discount_value}}% </span>
                                    @endif
                                </div>
                                @php
                                    $discountedAmount = 0;

                                    if($product->has_discount === '1'){

                                     $caclDiscount =   $product->discount_value /100 *  $product->prices->data[0]->unit_price->raw;

                                     $discountedAmount =  $product->prices->data[0]->unit_price->raw -  $caclDiscount  ;


                                    }
                                @endphp


                                <div class="product-info product-content">
                                    <a href="{{url('/product/'.$product->id.'?promotions='.$leftSidePromo)}}"><h6>{{$product->name}}</h6></a>
                                    @if($product->has_discount === '1')
                                        <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $discountedAmount  :0}} <br> <del><span>  {{$product->prices->data[0]->currency ?? 'NGN'}} {{  $product->prices->data[0]->unit_price->formatted  ?? 0}} </span></del> </h5>
                                    @else
                                        <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $product->prices->data[0]->unit_price->formatted :0}} </h5>
                                    @endif
{{--                                    <h5>{{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $product->prices->data[0]->unit_price->formatted :0}}</h5>--}}
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div class="color">
                                            @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'colour')
                                                <h5>color</h5>
                                            @endif
                                            <ul class="color-variant">
                                                @foreach($product->variants as $variant)
                                                    @if(strtolower($variant->product_variant_type) === 'colour')
                                                        <li class="{{$variant->product_variant}}"></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="size">
                                            @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'size')
                                                <h5>size</h5>
                                            @endif
                                            <ul class="size-box">
                                                @foreach($product->variants as $variant)
                                                    @if(strtolower($variant->product_variant_type) === 'size')
                                                        <li class="{{$variant->product_variant}}"></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="addtocart_btn">
                                            <a href="{{$product->id.'?promo_name='.$leftSidePromo}}" class="add-to-cart-btn">add to cart</a>
                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div>
                            @foreach($leftSideProductsRight  as $index => $product)
                            <div class="product-box">
                                <div class="img-block" style="position:relative;">
                                    <a href="{{url('/product/'.$product->id.'?promotions='.$leftSidePromo)}}">
                                        <img src="{{ isset($product->product_images[0]) ? asset($product->product_images[0]->url) : asset('assets/images/fashion/pro/1.jpg')}}"
                                                     class=" img-fluid bg-img"
                                                     alt=""></a>
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
{{--                                        <a href="{{$product->id}}"--}}
{{--                                           class="add-to-wishlist" title="Add to Wishlist">--}}
{{--                                            <i class="ti-heart" aria-hidden="true"></i></a>--}}
                                        <a href="{{url('/product/'.$product->id.'?promotions='.$leftSidePromo)}}"  title="View"><i class="ti-eye"
                                                                                                     aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    @if($product->has_discount === '1')
                                        <span style="position: absolute;top:8%; left: 5%; background : var(--company-primary-color); padding:2%;color:#fff; border-radius: 10%; "> - {{$product->discount_value}}% </span>
                                    @endif
                                </div>

                                @php
                                    $discountedAmount = 0;

                                    if($product->has_discount === '1'){
                                        $caclDiscount =   $product->discount_value /100 *  $product->prices->data[0]->unit_price->raw;
                                        $discountedAmount =  $product->prices->data[0]->unit_price->raw -  $caclDiscount  ;
                                    }
                                @endphp
                                <div class="product-info product-content">
                                    <a href="#"><h6>{{$product->name}}</h6></a>
                                    @if($product->has_discount === '1')
                                        <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $discountedAmount  :0}} <br> <del><span>  {{$product->prices->data[0]->currency ?? 'NGN'}} {{  $product->prices->data[0]->unit_price->formatted  ?? 0}} </span></del> </h5>
                                    @else
                                        <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $product->prices->data[0]->unit_price->formatted :0}} </h5>
                                    @endif
{{--                                    <h5>{{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $product->prices->data[0]->unit_price->formatted :0}}</h5>--}}
                                </div>
                                <div class="addtocart_box">
                                    <div class="addtocart_detail">
                                        <div class="color">
                                            @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'colour')
                                                <h5>color</h5>
                                            @endif
                                            <ul class="color-variant">
                                                @foreach($product->variants as $variant)
                                                    @if(strtolower($variant->product_variant_type) === 'colour')
                                                        <li class="{{$variant->product_variant}}"></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="size">
                                            @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'size')
                                                <h5>size</h5>
                                            @endif
                                            <ul class="size-box">
                                                @foreach($product->variants as $variant)
                                                    @if(strtolower($variant->product_variant_type) === 'size')
                                                        <li class="{{$variant->product_variant}}"></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="addtocart_btn">
                                            <a href="{{$product->id.'?promo_name='.$leftSidePromo}}" class="add-to-cart-btn">add to cart</a>

                                        </div>
                                    </div>
                                    <div class="close-cart">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 side-banner side-banner2 pe-0 d-none d-xl-block">
                    <a href="#"><img src="{{asset($productsSectionSpecial)}}" alt="" class=" img-fluid "></a>
                </div>
                <div class="col-xl-6 ps-0 ratio_square media-product-section">
                    <div class="tab-head">
                        <h2 class="title">{{$rightSidePromo}}</h2>
                    </div>
                    <div class="slide-2">
                        <div>
                            @foreach($rightSideProductsLeft as $index => $product)
                            <div class="media product-box" style="position: relative;">
                                <a href="{{url('/product/'.$product->id.'?promotions='.$rightSidePromo)}}" tabindex="0">
                                    <img class="img-fluid ed"
                                         src="{{ isset($product->product_images[0]) ? asset($product->product_images[0]->url) : asset('assets/images/fashion/pro/1.jpg')}}" alt="">
                                </a>
                                @if($product->has_discount === '1')
                                    <span style="position: absolute;top:20%; left: 10%; background : var(--company-primary-color); padding:1%;color:#fff; border-radius: 10%; "> - {{$product->discount_value}}% </span>
                                @endif
                                <div class="media-body align-self-center">
                                    <a href="#" tabindex="0">
                                        <h6>{{$product->name}}</h6>
                                    </a>
                                    @php
                                        $discountedAmount = 0;

                                        if($product->has_discount === '1'){

                                         $caclDiscount =   $product->discount_value /100 *  $product->prices->data[0]->unit_price->raw;

                                         $discountedAmount =  $product->prices->data[0]->unit_price->raw -  $caclDiscount  ;


                                        }
                                    @endphp

                                    @if($product->has_discount === '1')
                                        <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $discountedAmount  :0}} <br> <del><span>  {{$product->prices->data[0]->currency ?? 'NGN'}} {{  $product->prices->data[0]->unit_price->formatted  ?? 0}} </span></del> </h5>
                                    @else
                                        <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $product->prices->data[0]->unit_price->formatted :0}} </h5>
                                    @endif
{{--                                    <h5>{{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $product->prices->data[0]->unit_price->formatted :0}}</h5>--}}
                                    <div class="cart-info">
                                        <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                    class="ti-shopping-cart"></i></button>
{{--                                        <a href="{{$product->id}}"--}}
{{--                                           class="add-to-wishlist" title="Add to Wishlist">--}}
{{--                                            <i class="ti-heart" aria-hidden="true"></i></a>--}}
                                        <a href="{{url('/product/'.$product->id.'?promotions='.$rightSidePromo)}}"  title="View"><i class="ti-eye"
                                                                                                     aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="addtocart_box">
                                        <div class="addtocart_detail">
                                            <div class="color">
                                                @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'colour')
                                                    <h5>color</h5>
                                                @endif
                                                <ul class="color-variant">
                                                    @foreach($product->variants as $variant)
                                                        @if(strtolower($variant->product_variant_type) === 'colour')
                                                            <li class="{{$variant->product_variant}}"></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="size">
                                                @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'size')
                                                    <h5>size</h5>
                                                @endif
                                                <ul class="size-box">
                                                    @foreach($product->variants as $variant)
                                                        @if(strtolower($variant->product_variant_type) === 'size')
                                                            <li class="{{$variant->product_variant}}"></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="addtocart_btn">
                                                <a href="{{$product->id.'?promo_name='.$rightSidePromo}}" class="add-to-cart-btn">add to cart</a>
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
                        <div>
                            @foreach($rightSideProductsRight as $index => $product)
                                <div class="media product-box">
                                    <a href="{{url('/product/'.$product->id.'?promotions='.$rightSidePromo)}}" tabindex="0">
                                        <img class="img-fluid ed"
                                             src="{{ isset($product->product_images[0]) ? asset($product->product_images[0]->url) : asset('assets/images/fashion/pro/1.jpg')}}" alt="">
                                    </a>
                                    <div class="media-body align-self-center">
                                        <a href="{{url('/product/'.$product->id.'?promotions='.$rightSidePromo)}}" tabindex="0">
                                            <h6>{{$product->name}}</h6>
                                        </a>
                                        @php
                                            $discountedAmount = 0;

                                            if($product->has_discount === '1'){

                                             $caclDiscount =   $product->discount_value /100 *  $product->prices->data[0]->unit_price->raw;

                                             $discountedAmount =  $product->prices->data[0]->unit_price->raw -  $caclDiscount  ;

                                            }
                                        @endphp

                                        @if($product->has_discount === '1')
                                            <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $discountedAmount  :0}} <br> <del><span>  {{$product->prices->data[0]->currency ?? 'NGN'}} {{  $product->prices->data[0]->unit_price->formatted  ?? 0}} </span></del> </h5>
                                        @else
                                            <h5> {{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $product->prices->data[0]->unit_price->formatted :0}} </h5>
                                        @endif
{{--                                        <h5>{{$product->prices->data[0]->currency ?? 'NGN'}} {{ isset($product->prices->data[0])? $product->prices->data[0]->unit_price->formatted :0}}</h5>--}}
                                        <div class="cart-info">
                                            <button tabindex="0" class="addcart-box" title="Quick shop"><i
                                                        class="ti-shopping-cart"></i></button>
{{--                                            <a href="{{$product->id}}"--}}
{{--                                               class="add-to-wishlist" title="Add to Wishlist">--}}
{{--                                                <i class="ti-heart" aria-hidden="true"></i></a>--}}
                                            <a href="{{url('/product/'.$product->id.'?promotions='.$rightSidePromo)}}"  title="View"><i class="ti-eye"
                                                                                                         aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="addtocart_box">
                                            <div class="addtocart_detail">
                                                <div class="color">
                                                    @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'colour')
                                                        <h5>color</h5>
                                                    @endif
                                                    <ul class="color-variant">
                                                        @foreach($product->variants as $variant)
                                                            @if(strtolower($variant->product_variant_type) === 'colour')
                                                                <li class="{{$variant->product_variant}}"></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>

                                                <div class="size">
                                                    @if(isset($product->variants[0]) && strtolower($product->variants[0]->product_variant_type) === 'size')
                                                        <h5>size</h5>
                                                    @endif
                                                    <ul class="size-box">
                                                        @foreach($product->variants as $variant)
                                                            @if(strtolower($variant->product_variant_type) === 'size')
                                                                <li class="{{$variant->product_variant}}"></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>

                                                <div class="addtocart_btn">
                                                    <a href="{{$product->id.'?promo_name='.$rightSidePromo}}" class="add-to-cart-btn">add to cart</a>

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
        </div>
    </section>
    <!-- Product slider section end -->


    <!-- blog section start -->
{{--    <section class=" p-t-0  blog-section">--}}
{{--        <div class="container">--}}
{{--            <h2 class="title pt-0">from the blog</h2>--}}
{{--            <div class="slide-4">--}}
{{--                <div>--}}
{{--                    <a href="#" class="blog">--}}
{{--                        <div class="blog-image">--}}
{{--                            <img src="../assets/images/fashion/blog/1.jpg" class="img-fluid" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="blog-info">--}}
{{--                            <div>--}}
{{--                                <h5>25 july 2018</h5>--}}
{{--                                <p>Sometimes on purpose ected humour. dummy text.</p>--}}
{{--                                <h6>by: admin, 0 comment</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <a href="#" class="blog">--}}
{{--                        <div class="blog-image">--}}
{{--                            <img src="../assets/images/fashion/blog/2.jpg" class="img-fluid" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="blog-info">--}}
{{--                            <div>--}}
{{--                                <h5>25 july 2018</h5>--}}
{{--                                <p>Sometimes on purpose ected humour. dummy text.</p>--}}
{{--                                <h6>by: admin, 0 comment</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <a href="#" class="blog">--}}
{{--                        <div class="blog-image">--}}
{{--                            <img src="../assets/images/fashion/blog/5.jpg" class="img-fluid" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="blog-info">--}}
{{--                            <div>--}}
{{--                                <h5>25 july 2018</h5>--}}
{{--                                <p>Sometimes on purpose ected humour. dummy text.</p>--}}
{{--                                <h6>by: admin, 0 comment</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <a href="#" class="blog">--}}
{{--                        <div class="blog-image">--}}
{{--                            <img src="../assets/images/fashion/blog/4.jpg" class="img-fluid" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="blog-info">--}}
{{--                            <div>--}}
{{--                                <h5>25 july 2018</h5>--}}
{{--                                <p>Sometimes on purpose ected humour. dummy text.</p>--}}
{{--                                <h6>by: admin, 0 comment</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <a href="#" class="blog">--}}
{{--                        <div class="blog-image">--}}
{{--                            <img src="../assets/images/fashion/blog/3.jpg" class="img-fluid" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="blog-info">--}}
{{--                            <div>--}}
{{--                                <h5>25 july 2018</h5>--}}
{{--                                <p>Sometimes on purpose ected humour. dummy text.</p>--}}
{{--                                <h6>by: admin, 0 comment</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- blog secion end -->


    <!-- section start -->
{{--    <section class="">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-xl-4 logo no-border">--}}
{{--                    <h2 class="title">trusted brand</h2>--}}
{{--                    <div class="logo-3 border-logo">--}}
{{--                        <div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/1.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/2.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/3.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/4.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/5.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/6.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/7.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/8.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/2.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/3.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="../assets/images/logo/2.png" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="logo-img">--}}
{{--                                <img src="{{asset('assets/images/logo/3.png')}}" class=" img-fluid" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-xl-6 offset-xl-1">--}}
{{--                    <div class="app-section">--}}
{{--                        <div class="img-block">--}}
{{--                            <img src="{{asset('assets/hero/mobile.jpeg')}}"class=" img-fluid" alt="">--}}
{{--                        </div>--}}
{{--                        <div class="app-content">--}}
{{--                            <div>--}}
{{--                                <h5>download the big market app</h5>--}}
{{--                                <div class="app-buttons">--}}
{{--                                    <a href="#"><img src="{{asset('assets/images/app/app-storw.png')}}" class=" img-fluid" alt=""></a>--}}
{{--                                    <a href="#"><img src="{{asset('assets/images/app/play-store.png')}}" class=" img-fluid"--}}
{{--                                                     alt=""></a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- section end -->

@endsection

