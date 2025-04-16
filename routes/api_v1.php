<?php
/**
 * FILE TITLE GOES HERE
 *
 * DESCRIPTION OF THE PURPOSE AND USE OF THE CODE
 * MAY BE MORE THAN ONE LINE LONG
 * KEEP LINE LENGTH TO NO MORE THAN 96 CHARACTERS
 *
 * Filename:        api_v1.php
 * Location:        FILE_LOCATION
 * Project:         classtracker-2025-s1
 * Date Created:    14/04/2025
 *
 * Author:          Yui_Migaki
 *
 */

use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\v1\AuthApiController;
use App\Http\Controllers\Api\v1\PackageApiController;
use App\Http\Controllers\Api\v1\CourseApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthApiController::class, 'login']);


Route::apiResource('users', UserApiController::class)
    ->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserApiController::class)
        ->only(['store', 'update', 'destroy']);
});


Route::apiResource('courses', CourseApiController::class)
    ->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('courses', CourseApiController::class)
        ->only(['store', 'update', 'destroy']);
});

Route::apiResource('packages', PackageApiController::class)
    ->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('packages', PackageApiController::class)
        ->only(['store', 'update', 'destroy']);
});


