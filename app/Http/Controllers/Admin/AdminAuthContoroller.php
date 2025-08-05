<?php

namespace App\Http\Controllers\Admin;

use inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAuthContoroller extends Controller
{
    public function showLoginForm(){
        return inertia::render('Admin\Auth\Login');
    }
}
