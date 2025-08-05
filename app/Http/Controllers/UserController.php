<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class UserController extends Controller
{
    public function index(){
        $products = Product::with(['category', 'brand', 'product_images'])
                 ->orderBy('created_at')
                 ->limit(8)
                 ->get();


        // $products=Product::with(['category','brand','produc_images'])->getLimit()->get(8);

    return Inertia::render('User/index', [
        'products'=>$products,
        'canLogin' => app('router')->has('login'),
        'canRegister' => app('router')->has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);


    }
}
