@foreach($categories as $categoryItem)
    <option value = "{{ $categoryItem->id  ?? '' }}"
        @isset($product->id)
            @if($product->categories->contains('id', $categoryItem))
                selected = ""
            @endif
        @endisset
    >
        {{ $delimeter ?? '' }} {{ $categoryItem->title ?? '' }}

    @isset($categoryItem->children)
        @include('product._categories', [
            'categories' => $categoryItem->children,
            'delimeter' => '-' . $delimeter
        ])
    @endisset
@endforeach
