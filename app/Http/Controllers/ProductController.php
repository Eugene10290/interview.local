<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Filesystem\Filesystem;

class ProductController extends Controller
{

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

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
        $input = $this->imageProductRequest($request, null);
        $product = Auth::user()->product()->create($input);
        $this->multipleImagesUploading($request, $product);
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
        $user = User::find($product->user_id);
        $userName = $user->name;
        $productImages = $product->productImage()->get();
        //$storage = Storage::disk('photos')->getDriver()->getAdapter()->getPathPrefix();

        return view('product.show', compact('product', 'userName', 'productImages') );
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
        $request['product_image'] = '1578571537.jpg';
        $product->update($request->except('categories'));
        //$input = $this->imageProductRequest($request, $product);
        //$product->update(array($input));
        //$oldImage = $product->productImage()->get('filename');
        /*if($request->has('photos')) {
            app(\Illuminate\Filesystem\Filesystem::class)->delete(public_path('images/product_gallery/' . $oldImage));
            $this->multipleImagesUploading($request, $product);
        }*/
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
    protected function imageProductRequest($request, $product) {
       //dd($request->hasFile('product_image'));
        $input = $request->all();
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $savePath = public_path('images/products/' . $imageName);
            Image::make($image)
                ->save($savePath);

            $input = array_except($input, 'pathName');
            $input['product_image'] = $imageName;
            $title = $input['title'];
            $input['slug'] = str_slug($title);
            return $input;
        }else {
            return $input['product_image'] = $product->product_image;
        }
    }

    /**
     * Загрузка нескольких изображений к продукту
     *
     * @param $request
     * @param $product
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function multipleImagesUploading($request, $product){
        $this->validate($request, [
            'photos'=>'required',
        ]);
       // dd($request);
        if($request->hasFile('photos')){
            $allowedfileExtension =['jpg','png'];
            $files = $request->file('photos');

            foreach($files as $file){

                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                //dd($check);
                if($check)
                {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'filename' => $filename
                    ]);
                    $savePath = public_path('images/product_gallery/' . $filename);
                    Image::make($file)->save($savePath);

                    echo "Загрузка успешна";
                }else{
                    echo '<div class="alert alert-warning"><strong>Внимание!</strong>Ошибка загрузки изображений</div>';
                }
            }
        }
    }
}
