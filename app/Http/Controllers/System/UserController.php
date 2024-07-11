<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    const MODULE = 'Usuarios';

    public function index(Request $request)
    {
        return view('users.index', [
            'module' => self::MODULE,
        ]);
    }
}
