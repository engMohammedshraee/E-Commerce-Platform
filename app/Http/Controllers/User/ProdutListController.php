<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\ProductResource;
use App\Models\Brand;
use inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProdutListController extends Controller
{
    public function index(){
        $Products = Product::with('category','brand','product_images');
        $Productfilter=$Products->filter()->paginate(10)->withQueryString();
        $brands=Brand::get();
        $categories=Category::get();
        return inertia::render('User/ProductList',[
            'Products'=> ProductResource::collection($Productfilter),
            'brands'=>$brands,
            'categories'=>$categories
        ]);
    }
}
