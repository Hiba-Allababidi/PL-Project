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
    Route::get('/home', [ProductController::class,'show_products']);
    Route::delete('/delete_product/{id}',[ProductController::class,'delete_product']);
    Route::get('/show_product/{id}',[ProductController::class,'show_product']);
    Route::put('/update_product/{id}',[ProductController::class,'update_product']);
    Route::get('/search',[ProductController::class,'search_product']);

});













//    Route::post('/refresh', [JWTController::class, 'refresh']);

