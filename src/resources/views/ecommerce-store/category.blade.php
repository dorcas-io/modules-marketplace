@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? 'Categories'}}
@endsection

@section('content')


    <!-- breadcrumb start -->
    <section class="breadcrumb-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title">
                        <h2>{{$category}}</h2>
                    </div>
                </div>
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$category}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb End -->


    <!-- section start -->
    <section class="section-b-space ratio_square">
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="collection-content col">
                        <div class="page-main-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="top-banner-wrapper">
                                        <a href="#"><img src="{{asset('assets/images/about/about-us.jpg')}}" class="img-fluid " alt=""></a>
{{--                                        <div class="top-banner-content small-section">--}}
{{--                                            <h5>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h5>--}}
{{--                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="collection-product-wrapper">
                                        <div class="product-top-filter">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="product-filter-content">
                                                        <div class="search-count">
                                                            <h5>Showing Products {{$current_page}} - {{$pagination_total}} of {{$per_page}} Result</h5></div>
                                                        <div class="collection-view">
                                                            <ul>
                                                                <li><i class="fa fa-th grid-layout-view"></i></li>
                                                                <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                            </ul>
                                                        </div>
                                                        <div class="collection-grid-view">
                                                            <ul>
                                                                <li><a href="javascript:void(0)" class="product-2-layout-view"><ul class="filter-select"><li></li><li></li></ul></a></li>
                                                                <li><a href="javascript:void(0)" class="product-3-layout-view"><ul class="filter-select"><li></li><li></li><li></li></ul></a></li>
                                                                <li><a href="javascript:void(0)" class="product-4-layout-view"><ul class="filter-select"><li></li><li></li><li></li><li></li></ul></a></li>
                                                                <li><a href="javascript:void(0)" class="product-6-layout-view"><ul class="filter-select"><li></li><li></li><li></li><li></li><li></li><li></li></ul></a></li>
                                                            </ul>
                                                        </div>
{{--                                                        <div class="product-page-per-view">--}}
{{--                                                            <select>--}}
{{--                                                                <option value="High to low">24 Products Par Page</option>--}}
{{--                                                                <option value="Low to High">50 Products Par Page</option>--}}
{{--                                                                <option value="Low to High">100 Products Par Page</option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="product-page-filter">--}}
{{--                                                            <select>--}}
{{--                                                                <option value="High to low">Sorting items</option>--}}
{{--                                                                <option value="Low to High">50 Products</option>--}}
{{--                                                                <option value="Low to High">100 Products</option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-wrapper-grid">
                                            <div class="row">
                                                @if(count($products->data)> 0)
                                                @foreach($products->data as $index => $product)
                                                <div class="col-lg-2 col-md-4 col-6 col-grid-box">
                                                    <div class="product-box">
                                                        <div class="img-block">
                                                            <a href="{{url('/product/'.$product->id)}}">
                                                                <img src="{{$product->product_images[0]->url ?? 'assets/images/product/6.jpg'}}" class=" img-fluid bg-img" alt="">
                                                            </a>
                                                            <div class="cart-details">
                                                                <button tabindex="0" class="addcart-box" title="Quick shop"><i class="ti-shopping-cart" ></i></button>
                                                                <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart" aria-hidden="true"></i></a>
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view"  title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>
                                                                <a href="compare.html"  title="Compare"><i class="ti-reload" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="product-info">
                                                            <div>
                                                                <a href="#"><h6>{{$product->name}}</h6></a>
                                                                <p>{{$product->description}}</p>
                                                                <h5>{{$product->prices->data[0]->currency ?? 'NGN'}} {{$product->prices->data[0]->unit_price->formatted ?? 0}}</h5>
                                                            </div>
                                                        </div>
                                                        <div class="addtocart_box">
                                                            <div class="addtocart_detail">
                                                                <div>
{{--                                                                    <div class="color">--}}
{{--                                                                        <h5>color</h5>--}}
{{--                                                                        <ul class="color-variant">--}}
{{--                                                                            <li class="light-purple active"></li>--}}
{{--                                                                            <li class="theme-blue"></li>--}}
{{--                                                                            <li class="theme-color"></li>--}}
{{--                                                                        </ul>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="size">--}}
{{--                                                                        <h5>size</h5>--}}
{{--                                                                        <ul class="size-box">--}}
{{--                                                                            <li class="active">xs</li>--}}
{{--                                                                            <li>s</li>--}}
{{--                                                                            <li>m</li>--}}
{{--                                                                            <li>l</li>--}}
{{--                                                                            <li>xl</li>--}}
{{--                                                                        </ul>--}}
{{--                                                                    </div>--}}
                                                                    <div class="addtocart_btn">
                                                                        <a href="{{$product->id}}" class="add-to-cart-btn">add to cart</a>
{{--                                                                        <a href="javascript:void(0)"  data-bs-toggle="modal" class="closeCartbox" data-bs-target="#addtocart" tabindex="0">add to cart</a>--}}
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
                                                @else
                                                    <div class="col-lg-2 col-md-4 col-6 col-grid-box">
                                                        <div class="product-box">
                                                            <h3>No Product Available for this Category</h3>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @if($links)
                                        <div class="product-pagination mb-0">
                                            <div class="theme-paggination-block">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <nav aria-label="Page navigation">

                                                            <ul class="pagination">
                                                                <li class="page-item"><a class="page-link"  href="{{$previousString}}"  aria-label="Previous"><span aria-hidden="true"><i class="fa fa-chevron-left" aria-hidden="true"></i></span> <span class="sr-only">Previous</span></a></li>
                                                                @for($i = 0 ; $i < $pagination_total ; $i++)
                                                                  <li class="page-item active"><a class="page-link" href="?page={{$i+1}}">{{$i+1}}</a></li>
                                                                @endfor
                                                                <li class="page-item"><a class="page-link" href="{{$nextString}}" aria-label="Next"><span aria-hidden="true"><i class="fa fa-chevron-right" aria-hidden="true"></i></span> <span class="sr-only">Next</span></a></li>
                                                            </ul>

                                                        </nav>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <div class="product-search-count-bottom">
                                                            <h5>Showing Products {{$current_page}} - {{$pagination_total}} of {{$per_page}} Result</h5></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section End -->

@endsection

