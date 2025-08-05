<?php

namespace App\Http\Controllers\Admin;

use inertia\inertia;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $Products = Product::with(['category', 'brand', 'product_images'])->get();
        $categories = Category::get();
        $brands = Brand::get();

        return inertia::render('Admin/Products/index', [
            'user' => $user,
            'Products' => $Products,
            'categories' => $categories,
            'brands' => $brands,
            'status' => session('status')



        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $product = $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);
        $product = Product::create($product);
        //check if the product has images

        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                // إنشاء اسم فريد للملف
                $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension();

                // حفظ الملف في المسار المطلوب
                $path = Storage::disk('public')->putFileAs(
                    'images/product_images', // المسار داخل storage/app/public
                    $image,
                    $fileName
                );


                // حفظ المعلومات في قاعدة البيانات
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path // سيحتوي على 'images/product_images/اسم-الملف'
                ]);
            }
        }
        return redirect()->route('products.index')->with('status', 'product created successflu');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $fildes = $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);



        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                // إنشاء اسم فريد للملف
                $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension();

                // حفظ الملف في المسار المطلوب
                $path = Storage::disk('public')->putFileAs(
                    'images/product_images', // المسار داخل storage/app/public
                    $image,
                    $fileName
                );


                // حفظ المعلومات في قاعدة البيانات
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path // سيحتوي على 'images/product_images/اسم-الملف'
                ]);
            }
        }
        $product->update($fildes);
        return redirect()->back()->with('status', 'update successfly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $product=Product::get();
        // dd ($product);


        //     $product = Product::with('produc_images')->findOrFail($id);
        // dd($product);

        //     // 1. حذف الصور من التخزين
        //     foreach ($product->produc_images as $image) {
        //         Storage::disk('public')->delete($image->image);
        //     }

        //     // 2. حذف سجلات الصور من DB
        //     $product->produc_images()->delete();

        //     // 3. حذف المنتج
        //     $product->delete();
        // // $product = Product::findOrFail($id)->delete();
        // return redirect()->back()->with('status', 'delete successfly');

    }

  public function deleteproduct($id)
    {
        // $product=Product::get();
        // dd ($product);


            $product = Product::with('product_images')->findOrFail($id);
        // dd($product);

            // 1. حذف الصور من التخزين
            foreach ($product->product_images as $image) {
                Storage::disk('public')->delete($image->image);
            }

            // 2. حذف سجلات الصور من DB
            $product->product_images()->delete();

            // 3. حذف المنتج
            $product->delete();
        // $product = Product::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'delete successfly');

    }

    public function deleteImage($id)
    {
        $oldimage = ProductImage::findOrFail($id);
        $image = ProductImage::where('id', $id)->delete();
        Storage::disk('public')->delete($oldimage->image);
        return redirect()->route('products.index')->with('status', 'image deleted successfly');
    }
}
