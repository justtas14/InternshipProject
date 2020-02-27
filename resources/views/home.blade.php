@extends('layouts.app')

@section('content')
    <div class="container-fluid videoContainer">
        <video playsinline loop autoplay muted>
            <source src="{{asset('storage/videos/video.mp4')}}" type="video/mp4">
        </video>
        <button id="exploreBtn" onclick="goToProducts()" class="btn btn-outline-light">Explore our products</button>
    </div>
    @verbatim
        <div id="productsApp">
            <main-products-card></main-products-card>
        </div>
    @endverbatim
@endsection
