@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('product.update', $product) }}" method="post">
            @method('PUT')
            @csrf
            @include('product._form')
        </form>
    </div>
@endsection
