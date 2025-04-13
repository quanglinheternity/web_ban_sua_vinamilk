<?php

use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// mặc định apiRescour sẽ trỏ tới 5 phương thức mặc định
// trong controller apiProductController (index, store, show, update, destroy)
// thì ta cần phải tạo thêm đườn đẫn trỏ tới phương thức đó
//bắt buộc phải khai bao đặt trên route apiResource
Route::post('products/restore', [ApiProductController::class, 'restore']);
Route::apiResource('products', ApiProductController::class)->middleware('auth:sanctum');
