@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/products/show.css') }}" type="text/css">

    <title>{{ $product->title }}</title>
    <div class="container">
        <div class="row">
            <div class="news-body">
                <h1>{{ $product->title }}</h1>
                <p> Created by {{ $userName }}</p>
                <div class="mainImg"><img src="{{ asset('images/products/' . $product->product_image) }}"></div>
                <div class="text"> {!! $product->description !!}</div>
            </div>
        </div>
        <main role="main">
            <h3> Изображения товара</h3>
            <div class="album py-5 bg-light">
                <div class="container">
                    <div class="row">
                        @foreach($productImages as $productImage)
                            <div class="col-md-4">
                                <div class="card mb-4 box-shadow">
                                    <img class="card-img-top" src="{{ asset('images/product_gallery/' . $productImage->filename ) }}" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
