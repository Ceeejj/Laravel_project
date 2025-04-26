<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

############
Route::prefix('Admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [TaskController::class, 'index'])->name('dashboard');

    Route::get('Users', [UserController::class, 'index'])->name('users');
    Route::get('User/New', [UserController::class, 'create'])->name('user.create');
    Route::post('Users/New/Store', [UserController::class, 'store'])->name('user.store');
    Route::get('User/Edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('User/Update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('User/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');

    Route::get('Products', [ProductController::class, 'index'])->name('products');
    Route::get('Products/Create/New', [ProductController::class, 'create'])->name('product.create');
    Route::post('Products/Create/New/Store', [ProductController::class, 'store'])->name('product.store');
    Route::get('Products/Edit/{product_id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('Products/Edit/{product_id}/Update}', [ProductController::class, 'update'])->name('product.update');
    Route::post('Admin/Products/{product_id}/comment', [ProductController::class, 'addComment'])->name('product.comment');
    Route::delete('Products/Delete/{product_id}', [ProductController::class, 'destroy'])->name('product.delete');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/feedback', [FeedbackController::class, 'store']);


require __DIR__ . '/auth.php';
