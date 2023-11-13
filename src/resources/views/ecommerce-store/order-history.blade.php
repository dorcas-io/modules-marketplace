@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? ''}}
@endsection

@section('content')

<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>order history</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">order history</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->


<!--section start-->
<section class="cart-section order-history section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table cart-table table-responsive-xs">
                    <thead>
                    <tr class="table-head">
                        <th scope="col">product</th>
{{--                        <th scope="col">description</th>--}}
                        <th scope="col">price</th>
                        <th scope="col">quantity</th>
                        <th scope="col">status</th>
                    </tr>
                    </thead>
                    @foreach($orders as $index => $order)

                        @php $customerOrder = json_decode($order->order) ; @endphp
                    <tbody>
                    <tr>
{{--                        <td>--}}
{{--                            <a href="#"><img src="../assets/images/product/1.jpg" alt=""></a>--}}
{{--                        </td>--}}
                        <td><a href="#">order no: <span class="dark-data">{{$customerOrder->order->uuid}}</span>
                                <br>{{ $customerOrder->order->product_name}}</a>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="text" name="quantity" class="form-control input-number" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <h4 class="td-color">{{ $customerOrder->order->currency}} {{ $customerOrder->order->unit_price}}</h4></div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a></h2></div>
                            </div>
                        </td>
                        <td>
                            <h4>{{ $customerOrder->order->currency}} {{ $customerOrder->order->unit_price}}</h4></td>
                        <td>
{{--                            <span>Size: L</span>--}}
{{--                            <br>--}}
                            <span>Quantity: {{ $customerOrder->order->quantity}}</span>
                        </td>
                        <td>
                            <div class="responsive-data">
                                <h4 class="price">{{ $customerOrder->order->currency}} {{ $customerOrder->order->unit_price}}</h4>
                                |<span>Quantity: {{ $customerOrder->order->quantity}}</span>
                            </div>
                            <span class="dark-data">{{ $customerOrder->order->status}}</span>
                            <br>
                            ({{ $order->created_at->format('Y F d - h:i:s')}})
                        </td>
                    </tr>
                    </tbody>
                    @endforeach

                </table>
            </div>
        </div>
        <div class="row cart-buttons">
{{--            <div class="col-12 pull-right"><a href="#" class="btn btn-solid btn-sm">show all orders</a></div>--}}
        </div>
    </div>
</section>
<!--section end-->
@endsection