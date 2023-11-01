@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? 'Delivery'}}
@endsection

@section('content')

    <!-- breadcrumb start -->
    <section class="breadcrumb-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title">
                        <h2>Delivery Cost</h2>
                    </div>
                </div>
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Delivery Cost</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb End -->


    <!-- section start -->
    <section class="section-b-space">
        <div class="container">
            <div class="checkout-page">
                <div class="checkout-form">
                    <form action="{{url('get-delivery-cost')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-title">
                                    <h3>Billing Details</h3></div>
                                <div class="row check-out">
                                    @if(!isset($routes_sme->errors))
                                        @foreach($routes_sme as $index => $route)
                                            <div class="field-label">{{ $route[0]->company->name}} Delivery Route Pricing :  {{count($route)}} {{Str::plural('item',count($route))}} carted</div>
                                            @if(isset($route[0]->company->extra_data->logistics_settings) ?? isset($route->extra_data->logistics_settings->logistics_shipping))
                                                @if($route[0]->company->extra_data->logistics_settings->logistics_shipping === 'shipping_provider' )
                                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" value="{{$buyer_data['address']}}" name="provider[]" readonly>
                                                    </div>
                                                    <input type="hidden" value="{{$route[0]->company->uuid}}"  name="sme_ids[]" id="sme_ids" class="form-control" />

                                                @elseif($route[0]->company->extra_data->logistics_settings->logistics_shipping === 'shipping_myself')
                                                @if($route[0]->product_type === 'shipping')
                                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                        <select id="routes" name="routes[]" required>
                                                            @foreach($route as $i => $rt)
                                                            <option  value="{{$rt->uuid}}" >{{$rt->name}} - {{$rt->prices[0]->unit_price ?? null}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                             @else
                                                <div class="form-group col-md-12 col-sm-12 col-xs-12"   id="password-option">
                                                    <input type="text" required readonly>
                                                    <br>
                                                    <span style="background: red;color:white;padding:4px;">This Vendor is yet to set delivery locations , you can remove the item from carted list to proceed</span>
                                                </div>
                                             @endif
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <div>Cart Details</div>
                                        </div>

                                        <ul class="qty">
                                            @php $total = 0 @endphp
                                            @foreach($buyer_carts as $index => $cart)
                                            @php $total += $cart['price'] * $cart['quantity'] @endphp
                                            <li>{{$cart['name']}} × {{$cart['quantity']}} <span> &#8358; {{number_format($cart['price'])}}</span></li>
                                            @endforeach
                                        </ul>
                                        <ul class="total">
                                            <li>Total <span class="count">&#8358; {{number_format($total)}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="payment-box">
                                        <div class="title-box">
                                            <div><b> Delivery Address </b></div>
                                        </div>
                                        <div class="upper-box">
                                            <div class="payment-options">
                                                <div class="alert alert-success" role="alert">
                                                    <ul>
                                                        <li>Address : &nbsp;  <span> {{$buyer_data['address']}}</span></li>
                                                        <li>State  : &nbsp;  <span> {{$buyer_data['state']}}</span></li>
                                                        <li>Country : &nbsp;   <span> {{$buyer_data['country']}}</span></li>
                                                    </ul>
                                                    <div class="text-end"><a href="{{url('checkout')}}" class="btn-solid btn">Change Address</a></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-box">
                                        <div class="title-box">
                                            <div><b> Delivery Provider Options </b></div>
                                        </div>
                                        <div class="upper-box">
                                            <div class="payment-options">
                                                <ul>
                                                    @foreach($logistics_settings as $index => $logistic)
                                                        @if(!$logistic['disabled'])
                                                            <li>
                                                                <div class="radio-option">
                                                                    <input type="radio" name="logistics" value="{{$logistic['id']}}" id="logistics_option{{$index}}" @if($logistic['default']) checked="checked" @endif>
                                                                    <label for="logistics_option{{$index}}">{{$logistic['name']}}</label>
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="text-end"><button class="btn-solid btn">Get Delivery Cost</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->

@endsection