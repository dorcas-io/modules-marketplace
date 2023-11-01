@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? 'Payment'}}
@endsection


@section('content')
    <!-- breadcrumb start -->
    <section class="breadcrumb-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title">
                        <h2>Payments</h2>
                    </div>
                </div>
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Payments</li>
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
                    <form>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-xs-3">

                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <div>Product <span>Total</span></div>
                                        </div>
                                        <ul class="qty">
                                            @php $total = 0 @endphp
                                            @foreach(session()->get('cart') as $index => $cart)
                                                @php $total += $cart['price'] * $cart['quantity'] @endphp
                                                <li>{{$cart['name']}} × {{$cart['quantity']}} <span> &#8358; {{number_format($cart['price'])}}</span></li>
                                            @endforeach
                                        </ul>
                                        <ul class="sub-total">
                                            <li>Subtotal <span class="count">&#8358; {{number_format($total)}}</span></li>
                                            <li>Shipping
                                                <span class="count">&#8358; {{number_format($sumDeliveryAmount)}}</span>
                                            </li>
                                            <li>VAT
                                                <span class="count">&#8358; {{number_format($calculate_vat)}}</span>
                                            </li>
                                        </ul>
                                        <ul class="total">
                                            @php $totalSum = $sumDeliveryAmount + $total  @endphp
                                            <li>Total <span class="count"> &#8358; {{number_format($totalSum)}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="payment-box">
                                        <div class="upper-box">
                                            <div class="payment-options">
                                                <ul>
                                                    <li>
                                                        <div class="radio-option paypal">
                                                            <label for="payment-3"><span class="image"><img src="{{asset('assets/images/paypal.png')}}" alt=""></span></label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="text-end"><a href="{{url('initialize-payment')}}" class="btn-solid btn">Place Order</a></div>
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