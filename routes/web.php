<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
Route::get('/', function () {
    $products = \App\Models\Product::paginate(10);
    return view('product-browser', compact('products'));
});

