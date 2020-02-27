@extends('layouts.app')

@section('content')
    <div id="productApp">
        <main-product-info-card v-bind:id="{{ $productId }}"></main-product-info-card>
    </div>
@endsection
