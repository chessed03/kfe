<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    const MODULE = 'Productos';

    public function index(Request $request)
    {
        return view('products.index', [
            'module' => self::MODULE,
        ]);
    }
}
