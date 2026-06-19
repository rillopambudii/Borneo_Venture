<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    public function index()
    {
        $products = \App\Models\Merchandise::where('is_active', true)->get();
        return view('merchandise', compact('products'));
    }
}
