@extends('layouts.app')

@section('content')
    <div class="contaner">
        <form action="{{ route('category.store') }} " method="post">
            @csrf
            @include('category._form')
        </form>
    </div>
@endsection
