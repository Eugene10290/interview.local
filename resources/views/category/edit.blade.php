@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('category.update', $category) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @include('category._form')
        </form>
    </div>
@endsection
