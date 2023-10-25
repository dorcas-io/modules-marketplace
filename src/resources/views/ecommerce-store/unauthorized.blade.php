@extends('_layouts.app')

@section('page_title')
    {{$pageTitle ?? ''}}
@endsection
<style>
    .displayError {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 30%;
        height: 30vh;
        background-color: var(--company-secondary-color);
    }

    .displayError h4 {
        color: #fff;
    }

    .service-banner {
        margin-bottom: 1%;
    }
</style>

@section('content')

    <!-- service section start -->
    <section class="service-banner">
        <div class="container displayError">
            <br>

            <h2><i class="fa-solid fa-person-circle-question fa-beat-fade fa-2xl"></i></h2>
            <br><br>
            <h4> How did you get here ?</h4>
            <br>
            <button class="btn" style="background:var(--company-primary-color);color:#fff;">Contact Support</button>
            <br><br>
        </div>
    </section>
    <!-- service section end-->

@endsection
