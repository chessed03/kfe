<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    const MODULE = 'Precios';

    public function index(Request $request)
    {
        return view('prices.index', [
            'module' => self::MODULE,
        ]);
    }
}
