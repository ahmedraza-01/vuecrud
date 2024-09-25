<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\HandleInertiaRequests;

Route::middleware([HandleInertiaRequests::class])->group(function () {
    Route::get('/', function () {
        return view('index');
    });
    Route::get('/customers/create',[CustomerController::class,'create']);
    Route::get('/customers',[CustomerController::class,'index'])->name('customer.index');
    Route::post('/customers/store',[CustomerController::class,'store']);
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    Route::get('/customers/{customer}/edit ', [CustomerController::class, 'edit']);
    Route::put('/customers/{customer}', [CustomerController::class, 'update']);

    Route::get('/posts',[PostController::class,'index'])->name('posts.index');
    Route::get('/posts/create',[PostController::class,'create'])->name('posts.create');
    Route::post('/posts/store',[PostController::class,'store']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::get('/posts/{post}/edit ', [PostController::class, 'edit']);
    Route::put('/posts/{post}', [PostController::class, 'update']);




});