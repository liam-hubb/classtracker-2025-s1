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

use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\PackageApiController;
use App\Http\Controllers\Api\v1\CourseApiController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('courses', CourseApiController::class)
    ->only(['index', 'show', 'store']);

Route::apiResource('courses', CourseApiController::class)
    ->only(['update', 'destroy']);
//    ->middleware('auth:sanctum');

Route::apiResource('packages', PackageApiController::class)
    ->only(['index', 'show', 'store']);

Route::apiResource('packages', PackageApiController::class)
    ->only(['update', 'destroy']);
//    ->middleware('auth:sanctum');



//Route::group(['prefix' => 'v1'], function () {
//    Route::apiResource('courses', \App\Http\Controllers\CourseApiController::class)
//        ->except(['update', 'destroy']);
//
//    Route::apiResource('courses', \App\Http\Controllers\CourseApiController::class)
//        ->only(['update', 'destroy'])
//        ->middleware('auth:sanctum');
//});
