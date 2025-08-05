<?php

namespace App\Http\Controllers\Admin;

use inertia\inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminContoroller extends Controller
{
    public function index(){
        $user=auth()->user();
        return inertia::render('Admin/Dashboard',[
            'user'=>$user
        ]);
    }
}
