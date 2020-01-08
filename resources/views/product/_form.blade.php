<div class="form-group">
    <input type="text" class="form-control" name="title" value="{{ $product->title ?? '' }} "
           placeholder="Название товара"/>
    <input type="text" class="form-control" name="description" value="{{ $product->description ?? '' }} "
           placeholder="Описание"/>
    <input type="file" class="form-control" name="product_image">
    <input type="number" class="form-control" name="price" value="{{ $product->price ?? '' }}">
</div>

<div class="form-group">
    <select name="categories[]"  multiple="" class="form-control">
        @include('product._categories')
    </select>
</div>
<button type="submit" class="btn btn-primary">Сохранить</button>
