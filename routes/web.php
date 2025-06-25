<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Job;
use Inertia\Inertia;
use App\Models\Product;


Route::get('/test', function () {
    return Inertia::render('Welcome');
})->name('test');

Route::get('dashboard', function () {
   $products = Product::latest()->paginate(5);
    return Inertia::render('Dashboard', [
        'products' => $products
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::middleware(['auth', 'verified'])->group(function () {
   
    // Product Routes
    Route::get('/products/create', function () {
        return Inertia::render('products/Create');
    });

    Route::post('/products', [\App\Http\Controllers\ProductController::class, 'store']);

    Route::get('/products', function () {
    return Inertia::render('products/Index', [
        'products' => Product::latest()->get()
    ]);
    })->name('products.index');

    // ✅ Edit Product
    Route::get('/products/{product}/edit', [ProductController::class, 'edit']);


    // ✅ Update Product
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    // ✅ Delete Product
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';