@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? 'Single Product'}}
@endsection

@section('content')

<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>PRODUCT</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">PRODUCT</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->


<!-- section start -->
<section>
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-1 col-sm-2 col-xs-12">
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="slider-right-nav">
                                @foreach($product->data->product_images as $index => $image)
                                <div><img src="{{$image->url}}" alt="" class="img-fluid "></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-10 col-xs-12 order-up">
                    <div class="product-right-slick">
                        @foreach($product->data->product_images as $index => $image)
                        <div><img src="{{$image->url}}" alt="" class="img-fluid  image_zoom_cls-{{$index}}"></div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="product-right product-description-box">
                        <h2>{{$product->data->name}}</h2>
                        <div class="border-product">
                            <h6 class="product-title">product details</h6>
                            <p>{{$product->data->description}}</p>
                        </div>
{{--                        <div class="single-product-tables border-product detail-section">--}}
{{--                            <table>--}}
{{--                                <tbody>--}}
{{--                                <tr>--}}
{{--                                    <td>Febric:</td>--}}
{{--                                    <td>Chiffon</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>Color:</td>--}}
{{--                                    <td>Red</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>Material:</td>--}}
{{--                                    <td>Crepe printed</td>--}}
{{--                                </tr>--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
                        <div class="border-product">
                            <h6 class="product-title">share it</h6>
                            <div class="product-icon">
                                <ul class="product-social">
                                    @php
                                    $url = env('DORCAS_BASE_DOMAIN').'/product/'.$product->data->id;
                                    @endphp
                                    <li>
                                        <a href=`https://www.facebook.com/sharer/sharer.php?u={{$url}}&display=popup` target="_blank">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    <li><a href="#" id="whatsapp-share-button"  data-product="{{ $product->data->name }}"><i class="fa fa-whatsapp"></i></a></li>
                                </ul>
                                <form class="d-inline-block">
                                    <button class="wishlist-btn"><i class="fa fa-heart"></i><span class="title-font">Add To WishList</span></button>
                                </form>
                            </div>
                        </div>
                        <div class="border-product">
                            <h6 class="product-title">100% SECURE PAYMENT</h6>
                            <div class="payment-card-bottom">
                                <ul>
                                    <li>
                                        <a href="#"><img src="{{asset('assets/images/icon/visa.png')}}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="{{asset('assets/images/icon/mastercard.png')}}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="{{asset('assets/images/icon/paypal.png')}}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="{{asset('assets/images/icon/american-express.png')}}" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="{{asset('assets/images/icon/discover.png')}}" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="product-right product-form-box">
{{--                        <h4><del>$459.00</del><span>55% off</span></h4>--}}
                        <h3>{{$product->data->default_currency }} {{$product->data->prices->data[0]->unit_price->formatted ?? 0}}</h3>
                        @if(count($product->data->variants) > 0)
                            @if(isset($product->data->variants[0]) && strtolower($product->data->variants[0]->product_variant_type) === 'colour')
                              <h6 class="product-title">select color</h6>
                            @endif
                        <ul class="color-variant">
                            @foreach($product->data->variants as $variant)
                            @if(strtolower($variant->product_variant_type) === 'colour')
                            <li class="{{$variant->product_variant}}"></li>
                            @endif
                            @endforeach
                        </ul>
                        @endif
                        <div class="product-description border-product">
{{--                            <h6 class="product-title">Time Reminder</h6>--}}
{{--                            <div class="timer">--}}
{{--                                <p id="demo"><span>25 <span class="padding-l">:</span> <span class="timer-cal">Days</span> </span><span>22 <span class="padding-l">:</span> <span class="timer-cal">Hrs</span> </span><span>13 <span class="padding-l">:</span> <span class="timer-cal">Min</span> </span><span>57 <span class="timer-cal">Sec</span></span>--}}
{{--                                </p>--}}
{{--                            </div>--}}
                            @if(isset($product->data->variants[0]) && strtolower($product->data->variants[0]->product_variant_type) === 'size')
                            <h6 class="product-title">select size</h6>
                            @endif
                            <div class="size-box">
                                <ul>
                                    @foreach($product->data->variants as $variant)
                                        @if(strtolower($variant->product_variant_type) === 'size')
                                    <li class="active"><a href="javascript:void(0)">{{strtoupper($variant->product_variant)}}</a></li>
                                        @endif
                                    @endforeach
{{--                                    <li><a href="javascript:void(0)">m</a></li>--}}
{{--                                    <li><a href="javascript:void(0)">l</a></li>--}}
{{--                                    <li><a href="javascript:void(0)">xl</a></li>--}}
                                </ul>
                            </div>
                            <form action="{{url('add-to-cart/'.$product->data->id)}}" id="quantity_form">
                                @csrf
                            <h6 class="product-title">quantity</h6>
                            <div class="qty-box">
                                <div class="input-group"><span class="input-group-prepend"><button type="button" class="btn quantity-left-minus" data-type="minus" data-field=""><i class="ti-angle-left"></i></button> </span>
                                    <input type="text" name="quantity" class="form-control input-number" value="1"> <span class="input-group-prepend"><button type="button" class="btn quantity-right-plus" data-type="plus" data-field=""><i class="ti-angle-right"></i></button></span></div>
                            </div>
                            </form>
                        </div>
                        <div class="product-buttons">
                            <button  type="submit" form="quantity_form" class="btn btn-solid">add to cart</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section ends -->


<!-- product-tab starts -->
<section class="tab-product m-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-selected="true">Description</a>
                        <div class="material-border"></div>
                    </li>
{{--                    <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-selected="false">Details</a>--}}
{{--                        <div class="material-border"></div>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-selected="false">Video</a>--}}
{{--                        <div class="material-border"></div>--}}
{{--                    </li>--}}
                    <li class="nav-item"><a class="nav-link" id="review-top-tab" data-bs-toggle="tab" href="#top-review" role="tab" aria-selected="false">Write Review</a>
                        <div class="material-border"></div>
                    </li>
                </ul>
                <div class="tab-content nav-material" id="top-tabContent">
                    <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                        <p>{{$product->data->description}}</p>
                    </div>
{{--                    <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">--}}
{{--                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>--}}
{{--                        <div class="single-product-tables">--}}
{{--                            <table>--}}
{{--                                <tbody>--}}
{{--                                <tr>--}}
{{--                                    <td>Febric</td>--}}
{{--                                    <td>Chiffon</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>Color</td>--}}
{{--                                    <td>Red</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>Material</td>--}}
{{--                                    <td>Crepe printed</td>--}}
{{--                                </tr>--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                            <table>--}}
{{--                                <tbody>--}}
{{--                                <tr>--}}
{{--                                    <td>Length</td>--}}
{{--                                    <td>50 Inches</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>Size</td>--}}
{{--                                    <td>S, M, L .XXL</td>--}}
{{--                                </tr>--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">--}}
{{--                        <div class="mt-4 text-center">--}}
{{--                            <iframe width="560" height="315" src="https://www.youtube.com/embed/BUWzX78Ye_8" allow="autoplay; encrypted-media" allowfullscreen></iframe>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="tab-pane fade" id="top-review" role="tabpanel" aria-labelledby="review-top-tab">
                        <form class="theme-form" method="post"  id="addReview">
{{--                            @csrf--}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="media">
                                        <label>Rating</label>
                                        <div class="media-body ms-3">
                                            <div class="rating three-star"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Your name" required>
                                </div>

                                <div class="col-md-12">
                                    <label for="review">Review Title</label>
                                    <input type="text" class="form-control" id="review_subject" name="review_subject" placeholder="Enter your Review Subjects" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="review">Review Title</label>
                                    <textarea class="form-control" placeholder="Write Your reviews  Here" id="reviews" name="reviews" rows="6"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-solid" type="submit">Submit YOur Review</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product-tab ends -->


<!-- product section start -->
<section class="section-b-space ratio_square product-related">
    <div class="container">
        <div class="row">
            <div class="col-12 ">
                <h2 class="title pt-0">related products</h2></div>
        </div>
        <div class="slide-6">
            <div class="">
                <div class="product-box">
                    <div class="img-block">
                        <a href="#"><img src="../assets/images/product/1.jpg" class=" img-fluid bg-img" alt=""></a>
                        <div class="cart-details">
                            <button tabindex="0"  class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>
                            <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view"  title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                            <a href="compare.html"  title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
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
                                    <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="close-cart">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="product-box">
                    <div class="img-block">
                        <a href="#"><img src="../assets/images/product/2.jpg" class=" img-fluid bg-img" alt=""></a>
                        <div class="cart-details">
                            <button tabindex="0"  class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>
                            <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view"  title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                            <a href="compare.html"  title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
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
                                    <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="close-cart">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="product-box">
                    <div class="img-block">
                        <a href="#"><img src="../assets/images/product/3.jpg" class=" img-fluid bg-img" alt=""></a>
                        <div class="cart-details">
                            <button tabindex="0"  class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>
                            <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view"  title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                            <a href="compare.html"  title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
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
                                    <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="close-cart">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="product-box">
                    <div class="img-block">
                        <a href="#"><img src="../assets/images/product/4.jpg" class=" img-fluid bg-img" alt=""></a>
                        <div class="cart-details">
                            <button tabindex="0"  class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>
                            <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view"  title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                            <a href="compare.html"  title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
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
                                    <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="close-cart">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="product-box">
                    <div class="img-block">
                        <a href="#"><img src="../assets/images/product/5.jpg" class=" img-fluid bg-img" alt=""></a>
                        <div class="cart-details">
                            <button tabindex="0"  class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>
                            <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view"  title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                            <a href="compare.html"  title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
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
                                    <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="close-cart">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="product-box">
                    <div class="img-block">
                        <a href="#"><img src="../assets/images/product/6.jpg" class=" img-fluid bg-img" alt=""></a>
                        <div class="cart-details">
                            <button tabindex="0"  class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>
                            <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view"  title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                            <a href="compare.html"  title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
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
                                    <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="close-cart">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="product-box">
                    <div class="img-block">
                        <a href="#"><img src="../assets/images/product/6.jpg" class=" img-fluid bg-img" alt=""></a>
                        <div class="cart-details">
                            <button tabindex="0"  class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>
                            <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view"  title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                            <a href="compare.html"  title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="product-info">
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
                                    <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>
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
</section>

<div class="modal fade" id="modalRating" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="form-group">
                    <label for="rating" style="font-size: 25px">Add Rating</label>
                    <br><br>
                    <div class="rating">
                        <input type="radio" class="ratings" id="star5" name="rating" value="5" required>
                        <label for="star5"></label>
                        <input type="radio"  class="ratings"  id="star4" name="rating" value="4" required>
                        <label for="star4"></label>
                        <input type="radio"  class="ratings"  id="star3" name="rating" value="3" required>
                        <label for="star3"></label>
                        <input type="radio"  class="ratings"  id="star2" name="rating" value="2" required>
                        <label for="star2"></label>
                        <input type="radio"  class="ratings" id="star1" name="rating" value="1" required>
                        <label for="star1"></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancel-rating-btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{--                    <button type="submit" id="submitRating" class="btn btn-primary">Add Rating</button>--}}
            </div>
        </div>
    </div>
</div>
<!-- product section end -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('whatsapp-share-button').addEventListener('click', function(event) {
        event.preventDefault();
        const productName = this.getAttribute('data-product');
        const productUrl =  window.location.href; // this.getAttribute('data-url');
        window.location.href = `/share-product?product=${encodeURIComponent(productName)}&url=${encodeURIComponent(productUrl)}`;
    });


    $('#addReview').on('submit', function(event) {

        event.preventDefault();

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        let  productId   = `{!! $product->data->id !!}`

        let full_name = document.getElementById("full_name").value;
        let email = document.getElementById("email").value;
        let reviews = document.getElementById("reviews").value;


        $('#modalRating').modal('show');

        var items = document.getElementsByClassName('ratings');

        Array.from(items).forEach(function(item) {
            item.addEventListener('click', function(event) {
                let rating  = event.srcElement.defaultValue;
                sessionStorage.setItem('rating', rating);
                if(rating) {
                    $.ajax({
                        url: '/add-review/' + productId,
                        method: 'post',
                        data: {
                            full_name: full_name,
                            email: email,
                            reviews : reviews,
                            rating : rating,
                            _token: csrfToken
                        },
                        success: function (response) {
                            if (response.success) {
                                $.notify({
                                    icon: 'fa fa-check',
                                    title: 'Success!',
                                    message: 'Product review added successfully'
                                },{
                                    element: 'body',
                                    position: null,
                                    type: "success",
                                    allow_dismiss: true,
                                    newest_on_top: false,
                                    showProgressbar: true,
                                    placement: {
                                        from: "top",
                                        align: "right"
                                    },
                                    offset: 20,
                                    spacing: 10,
                                    z_index: 10031,
                                    delay: 5000,
                                    animate: {
                                        enter: 'animated fadeInDown',
                                        exit: 'animated fadeOutUp'
                                    },
                                    icon_type: 'class',
                                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                                        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                                        '<span data-notify="icon"></span> ' +
                                        '<span data-notify="title">{1}</span> ' +
                                        '<span data-notify="message">{2}</span>' +
                                        '<div class="progress" data-notify="progressbar">' +
                                        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                                        '</div>' +
                                        '<a href="{3}" target="{4}" data-notify="url"></a>' +
                                        '</div>'
                                });

                                setTimeout(function () {
                                    location.reload()
                                }, 3000);
                            }
                        }
                    });
                }
            });
        });



        $('#cancel-rating-btn').on('click', function(e) {
            e.preventDefault();
            $('#modalRating').modal('hide');
        });




    });

</script>
@endsection
