@extends('layouts.app')
<link href="{{ asset('css/products/show.css') }}" type="text/css">
@section('content')
    <title>{{ $product->title }}</title>
    <div class="container">
        <div class="row">
            <div class="news-body">
                <h1>{{ $product->title }}</h1>
                <div class="mainImg"><img src="{{ asset('images/products/'.$product->product_image) }}"></div>
                <div class="text"> {!! $product->description !!}</div>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/js/jquery-3.3.1.min.js') }}"></script>
@endsection
