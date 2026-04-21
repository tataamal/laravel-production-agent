<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AiQueryController;
use App\Http\Controllers\Api\AiSearchController;

// 1. Ubah sanctum menjadi api (Passport)
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// 2. Pastikan endpoint AI menggunakan auth:api
Route::middleware('auth:api')->group(function () {
    Route::post('/ask-erp', AiQueryController::class);
    Route::post('/v1/ai-query', [AiSearchController::class, 'search']);
});