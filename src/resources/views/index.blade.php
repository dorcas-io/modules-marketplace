@extends('layouts.tabler')
@section('body_content_header_extras')

@endsection
@section('body_content_main')
@include('layouts.blocks.tabler.alert')

<div class="row">
    @include('layouts.blocks.tabler.sub-menu')

    <div class="col-md-4 col-xl-4">
        <div class="card">
            <div class="card-status bg-indigo"></div>
            <div class="card-header">
                <h3 class="card-title">Services</h3>
                <div class="card-options">
                    <a href="{{ route('marketplace-services') }}" class="btn btn-indigo">Explore Services</a>
                </div>
            </div>
            <div class="card-body">
                Services are <em>non-physical goods</em> offered by <strong>professionals</strong> such as <em>Marketing, Legal, HR, Financial &amp; Technology consultants</em>.
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xl-4">
        <div class="card">
            <div class="card-status bg-cyan"></div>
            <div class="card-header">
                <h3 class="card-title">Products</h3>
                <div class="card-options">
                    <a href="{{ route('marketplace-products') }}" class="btn btn-cyan">Explore Products</a>
                </div>
            </div>
            <div class="card-body">
                Products are <em>physical goods</em> offered by<strong>vendors</strong> which are SMEs with <em>Online Stores</em>. A wide variety of products are available in various categories.
            </div>
        </div>
    </div>

</div>


@endsection
@section('body_js')
    
@endsection
