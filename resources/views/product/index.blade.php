@extends('layouts.app')

@section('content')
   <main role="main">

       <div class="album py-5 bg-light">
           <div class="container">
               <a class="btn btn-success" style="margin-bottom: 5px" href=" {{ route('product.create') }}">Создать продукт</a>
                   <div class="row">
                       @forelse($products as $product)
                       <div class="col-md-4">
                           <div class="card mb-4 box-shadow">
                               <img class="card-img-top" src="{{ asset('images/products/' . $product->product_image) }}" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                               <div class="card-body">
                                   <p class="card-text"> {{ $product->title }} </p>
                                   <div class="d-flex justify-content-between align-items-center">
                                       <div class="btn-group">
                                           <a href="{{ route('product.show', $product) }}" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                                           <a href="{{ route('product.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Редактирование</a>
                                       </div>
                                       <small class="text-muted btn btn-success"> {{ $product->price }} $</small>
                                   </div>
                               </div>
                           </div>
                       </div>
                       @empty<h1 class="text-center">Товары отсутствуют</h1>@endforelse
                   </div>
               {!! $products->links() !!}
           </div>
       </div>
   </main>
@endsection
