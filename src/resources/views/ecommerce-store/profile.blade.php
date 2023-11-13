@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? 'Profile'}}
@endsection


@section('content')
    <!-- breadcrumb start -->
    <section class="breadcrumb-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title">
                        <h2>profile</h2>
                    </div>
                </div>
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb End -->


    <!-- personal deatail section start -->
    <section class="contact-page register-page">
        <div class="container">
            <div class="row">
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                    <p> {{$error}}</p>
                @endforeach
                </div>
                @endif
                <div class="col-sm-12">
                    <h3 class="title pt-0">PERSONAL DETAIL</h3>
                    <form class="theme-form" method="post" action="{{url('update-profile/'.$user->id)}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control" id="name" name="first_name" value="{{$user->first_name}}">
                            </div>
                            <div class="col-md-6">
                                <label for="email">Last Name</label>
                                <input type="text" class="form-control" id="last-name" name="last_name" value="{{$user->last_name}}" >
                            </div>
                            <div class="col-md-6">
                                <label for="review">Phone number</label>
                                <input type="text" class="form-control"  name="phone" value="{{$user->phone}}" >
                            </div>
                            <div class="col-md-6">
                                <label for="email">Email</label>
                                <input type="text" class="form-control"  placeholder="Email"  name="email"  value="{{$user->email}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-solid" type="submit">Update Profile</button>
                        </div>
                        <br><br>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->


    <!-- address section start -->
{{--    <section class="contact-page register-page section-b-space">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-sm-12">--}}
{{--                    <h3 class="title pt-0">SHIPPING ADDRESS</h3>--}}
{{--                    <form class="theme-form">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <label for="name">Address *</label>--}}
{{--                                <input type="text" class="form-control" id="address-two" placeholder="Address" required="">--}}
{{--                            </div>--}}

{{--                            <div class="col-md-6 select_input">--}}
{{--                                <label for="review">Country *</label>--}}
{{--                                <input type="text" class="form-control" id="address-two" placeholder="Address" required="">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <label for="review">City *</label>--}}
{{--                                <input type="text" class="form-control" id="city" placeholder="City" required="">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <label for="review">Region/State *</label>--}}
{{--                                <input type="text" class="form-control" id="region-state" placeholder="Region/state" required="">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12">--}}
{{--                                <button class="btn btn-sm btn-solid" type="submit">Save setting</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- Section ends -->

@endsection