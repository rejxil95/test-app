<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Register API resource routes for the ProductController
// This generates routes for:
// GET    /api/products           → index
// POST   /api/products           → store
// GET    /api/products/{id}      → show
// PUT    /api/products/{id}      → update
// PATCH  /api/products/{id}      → update
// DELETE /api/products/{id}      → destroy
Route::apiResource('products', ProductController::class);
