<?php

use App\Classes\ApiResponse;
use Illuminate\Support\Facades\Route;



/**
 * API Routes defined by version in separate files.
 *
 * V1   routes/api_v1.php
 * V2   routes/api_v2.php
 *
 */
Route::prefix('v1')->group(base_path('routes/api_v1.php'));

Route::prefix('v2')->group(base_path('routes/api_v2.php'));

/**
 * Fallback to 404
 */

Route::fallback(static function(){
    return ApiResponse::error(
        [],
        "Page Not Found. If error persists, contact info@website.com",
        404
    );

});
