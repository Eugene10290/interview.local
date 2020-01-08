<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index', [
            'products' => Product::paginate(6)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create', [
            'product' => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimeter' => '',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $this->imageProductRequest($request);
        $product = Auth::user()->product()->create($input);
        //categories attaching
        if($request->has('categories')){
            $product->categories()
                ->attach($request->input('categories')  );
        }

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit', [
            'product' => $product,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimeter' => '',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->except('categories'));

        $product->categories()->detach();
        if($request->has('categories')){
            $product->categories()
                ->attach($request->input('categories'));
        }

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Функция обрезки и загрузки изображения для статьи, генерации слага
     *
     * @param $request
     * @return array
     */
    protected function imageProductRequest($request) {
        if ($request->has('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $savePath = public_path('images/products/' . $imageName);
            Image::make($image)
                ->save($savePath);
            $input = $request->all();
            $input = array_except($input, 'pathName');
            $input['product_image'] = $imageName;
            $title = $input['title'];
            $input['slug'] = str_slug($title);
            return $input;
        }
    }
}
