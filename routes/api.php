<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\ProductController;


Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/register', [JWTController::class, 'register']);
    Route::post('/login', [JWTController::class, 'login']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::get('/me', [JWTController::class, 'me']);
    Route::post('/add_product',[ProductController::class,'add_product']);
});













//    Route::post('/refresh', [JWTController::class, 'refresh']);

