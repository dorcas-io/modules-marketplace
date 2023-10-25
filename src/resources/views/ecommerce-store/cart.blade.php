
@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? 'Cart'}}
@endsection

@section('content')
<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space" >
{{--    style="background: var(--company-secondary-color);"--}}
    <div class="container" >
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>cart</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->


<!--section start-->
<section class="cart-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table cart-table table-responsive-xs striped-table">
                    <thead>
                    <tr class="table-head">
                        <th scope="col">image</th>
                        <th scope="col">product name</th>
                        <th scope="col">price</th>
                        <th scope="col">quantity</th>
                        <th scope="col">action</th>
                        <th scope="col">total</th>
                    </tr>
                    </thead>
                    @php $total = 0 @endphp
                    @foreach($carts as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                    <tbody>
                    <tr>

                        <td>
                            <a href="#"><img src="{{$details['image'] ?? asset('assets/images/product/1.jpg')}}" alt=""></a>
                        </td>
                        <td><a href="#">{{ $details['name'] }}</a>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="text" name="quantity" class="form-control input-number" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"> &#8358; {{ number_format($details['price']) }}</h2></div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a></h2></div>
                            </div>
                        </td>
                        <td>
                            <h2> &#8358; {{ number_format($details['price']) }}</h2></td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control input-number" value="{{ $details['quantity'] }}">
                                </div>
                            </div>
                        </td>
                        <td><a href="#" class="icon"><i class="ti-close"></i></a></td>
                        <td>
                            <h2 class="td-color"> &#8358; {{  number_format($details['price']) }}</h2></td>
                    </tr>
                    </tbody>
                    @endforeach
                </table>
                <table class="table cart-table table-responsive-md">
                    <tfoot>
                    <tr>
                        <td>total price :</td>
                        <td>
                            <h2> &#8358; {{number_format( $total) }}</h2></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row cart-buttons">
            <div class="col-6"><a href="{{url('/')}}" class="btn btn-solid">continue shopping</a></div>
            <div class="col-6"><a href="{{url('/checkout')}}" class="btn btn-solid">check out</a></div>
        </div>
    </div>
</section>
<!--section end-->
@endsection