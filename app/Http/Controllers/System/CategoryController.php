<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    const MODULE = 'Categorias';

    public function index(Request $request)
    {
        return view('categories.index', [
            'module' => self::MODULE,
        ]);
    }

}
