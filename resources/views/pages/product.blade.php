@extends('layouts.app')

@section('content')
    <div id="productApp">
        <main-product-info-card v-bind:id="{{ $productId }}" :is-admin="{{ json_encode($isAdmin) }}" :token="{{ json_encode($token) }}">
        </main-product-info-card>
    </div>
@endsection
