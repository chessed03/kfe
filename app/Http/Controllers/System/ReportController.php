<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    const MODULE = 'Reportes';

    public function index(Request $request)
    {
        return view('reports.index', [
            'module' => self::MODULE,
        ]);
    }
}
