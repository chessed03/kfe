<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const MODULE = 'Home';

    public function index(Request $request)
    {
        return view('home.index', [
            'module' => self::MODULE,
        ]);
    }

    public function accessDenied(Request $request)
    {
        return view('home.access-denied', [
            'module' => self::MODULE,
        ]);
    }
}
