@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? 'Checkout'}}
@endsection
<style>
    #password-option{
        display:none;
    }
</style>

@section('content')


<!-- breadcrumb start -->
<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>Check-out</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Delivery Address</li>
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
                <form method="post" action="{{url('calculate-delivery')}}" id="calculateDelivery">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-xs-12">
                            <div class="checkout-title">
                                <h3>Billing Details</h3></div>
                            <div class="row check-out">
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <div class="email-input">Email Address</div>
                                    <input type="text" name="email" value=""  id="email-input" placeholder="">
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <div class="first_name-input">First Name</div>
                                    <input type="text" name="first_name" value="" id="first_name-input" placeholder="">
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <div class="last_name-input">Last Name</div>
                                    <input type="text" name="last_name" value="" id="last_name-input" placeholder="">
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <div class="phone-input">Phone</div>
                                    <input type="text" name="phone" value="" id="phone-input" placeholder="">
                                </div>

                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <div class="address">Address ( <span style="color: var( --company-primary-color) ; font-size:80%;"> Ensure to select from the list of suggested addresses for accuracy</span> )</div>
                                    <input type="text" name="address" id="address" value=""
                                           placeholder="Street address"
                                           oncopy="return false;"
                                           onpaste="return false;"
                                           oncut="return false;"
                                    >
                                </div>
                                <div  class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <p class="fillAddress"></p>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="create_account_box">
                                    <input type="checkbox" name="create_account"  id="account-option"> &ensp;
                                    <label for="account-option">Create An Account?</label>
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12"   id="password-option">
                                    <div class="field-label">Enter Password</div>
                                    <input type="password" name="password" value="" placeholder="Enter Password">
                                </div>

                                    <input type="hidden" name="latitude" value="" id="latitude" >
                                    <input type="hidden" name="longitude" value="" id="longitude" >
                                    <input type="hidden" name="state" value="" id="state" >
                                    <input type="hidden" name="country" value="" id="country" >
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-xs-12">
                            <div class="checkout-details">
                                <div class="order-box">
                                    <div class="title-box">
                                        <div>Delivery Address</div>
                                    </div>
                                    <div id="map" style="width: 100%; height: 400px;"></div>
                                </div>
                                <div class="payment-box">
                                    <div class="text-end"><button class="btn-solid btn" >Confirm Address</button></div>
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

<script>
    const apiKey = '{{ env('CREDENTIAL_GOOGLE_API_KEY') }}';
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places&callback=initMap`;
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
</script>

<script>
    let map;
    let marker;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 0, lng: 0 },
            zoom: 10
        });

        const input = document.getElementById('address');
        const autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                alert('No details available for input: ' + place.name);
                return;
            }

            map.setCenter(place.geometry.location);

            if (marker) {
                marker.setMap(null); // Remove the previous marker
            }

            marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location,
                title: 'Selected Location'
            });
            console.log(marker.getPosition().lng());
            const longitude = document.getElementById('longitude');
            const latitude  = document.getElementById('latitude');
            longitude.value = marker.getPosition().lng();
            latitude.value = marker.getPosition().lat();



            const lat = marker.getPosition().lat();
            const lng = marker.getPosition().lng();

            const geocoder = new google.maps.Geocoder();

            geocoder.geocode({ 'location': { lat: lat, lng: lng } }, (results, status) => {
                if (status === 'OK') {
                    if (results[0]) {

                        const addressComponents = results[0].address_components;
                        for (let component of addressComponents) {
                            if (component.types.includes('administrative_area_level_1')) {
                                // State information
                                 const state = component.long_name;
                                 const stateAddress = document.getElementById('state');
                                 stateAddress.value = state ;

                            } else if (component.types.includes('country')) {

                                // Country information
                                const country = component.long_name;
                                const countryAddress = document.getElementById('country');
                                countryAddress.value = country ;
                            }
                        }
                    } else {
                        console.log('No results found');
                    }
                } else {
                    console.log('Geocoder failed due to: ' + status);
                }
            });
        });



        document.getElementById('confirmLocation').addEventListener('click', function() {
            if (marker) {
                alert('Selected Latitude: ' + marker.getPosition().lat() + ', Longitude: ' + marker.getPosition().lng());
            } else {
                alert('Please select a location first.');
            }
        });
    }
</script>

<script>
    const toggleInput = document.getElementById('account-option');
    const inputField = document.getElementById('password-option');

    toggleInput.addEventListener('click', function() {
        toggleInput.checked ?
            inputField.style.display = 'block' :
            inputField.style.display = 'none';
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let typingTimer;
    const doneTypingInterval = 1000; // 1 second

    $('#email-input').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(fetchUserData, doneTypingInterval);
    });

    function fetchUserData() {
        const email = $('#email-input').val();
        const create_account_box = document.getElementById('create_account_box');



        $.ajax({
            url: '/fetch-user-data',
            method: 'GET',
            data: { email: email },
            success: function (response) {
                // Handle the response and display user data
                if (response) {
                    // console.log(response.data)
                    if(response.success){
                        $('#first_name-input').val(response.data.first_name);
                        $('#last_name-input').val(response.data.last_name);
                        $('#phone-input').val(response.data.phone);
                        // $('#create_account_box').hide();
                        create_account_box.style.display = 'none';
                    }else{
                        $('#first_name-input').val('');
                        $('#last_name-input').val('');
                        $('#phone-input').val('');
                        create_account_box.style.display = 'block';
                        // $('#create_account_box').show();
                    }

                } else {

                }
            }
        });
    }
</script>
@endsection