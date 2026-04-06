<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); 



Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']); 
    Route::post('/login', [AuthController::class, 'login']);      

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);         
        Route::post('/logout', [AuthController::class, 'logout']); 
    });
});


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'تم تفعيل البريد الإلكتروني بنجاح.']);
})->middleware('signed')->name('verification.verify');


Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);   
    Route::get('/orders', [OrderController::class, 'index']);     
    Route::get('/orders/{id}', [OrderController::class, 'show']);  
});


Route::middleware(['auth:sanctum', 'is_admin'])->prefix('v1/admin')->group(function () {
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']); 
});


Route::prefix('v1')->group(function () {
    
    Route::get('/categories', [CategoryController::class, 'index']);     
    Route::get('/products', [ProductController::class, 'index']);          
    Route::get('/products/{product}', [ProductController::class, 'show']);   

    Route::middleware(['auth:sanctum', 'is_admin'])->prefix('admin')->group(function () {
        Route::post('/categories', [CategoryController::class, 'store']);    
        Route::patch('/categories/{category}', [CategoryController::class, 'update']); 
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']); 

        Route::post('/products', [ProductController::class, 'store']);    
        Route::patch('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']); 
        Route::post('/products/{product}/images', [ProductController::class, 'uploadImages']); 
    });
});


Route::middleware(['auth:sanctum', 'is_admin'])->prefix('v1/admin')->group(function () {
    Route::get('/users', [UserController::class, 'index']);               
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggleStatus']); 
});
