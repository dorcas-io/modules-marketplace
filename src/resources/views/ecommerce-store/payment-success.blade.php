@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? 'Payment'}}
@endsection
<style>
    .checkout-details{
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    .payment-box{
        margin-top:1em;
    }
</style>

@section('content')
    <!-- breadcrumb start -->
{{--    <section class="breadcrumb-section section-b-space">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="page-title">--}}
{{--                        <h2>Payments</h2>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-12">--}}
{{--                    <nav aria-label="breadcrumb" class="theme-breadcrumb">--}}
{{--                        <ol class="breadcrumb">--}}
{{--                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>--}}
{{--                            <li class="breadcrumb-item active" aria-current="page">Successful Purchase</li>--}}
{{--                        </ol>--}}
{{--                    </nav>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
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
                                            <svg xmlns="http://www.w3.org/2000/svg" height="8em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#0fbd63}</style><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                                        </div>
                                    </div>
                                    <div class="payment-box">
                                        <h5>Total : #5000 </h5>
                                    </div>

                                    <div class="payment-box">
                                        <h5>Order Reference ID : #1717177171</h5>
                                    </div>
                                    <div class="payment-box">
                                        <div class="text-end">
                                            <a href="{{url('/')}}" class="btn-solid btn">Continue Shopping</a>
                                        </div>
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