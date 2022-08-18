<?php

use Illuminate\Support\Facades\Route;
use Calls\CallController;

Route::group([
    'middleware' => ['auth:sanctum', 'user_checker']
], function () {
    Route::apiResource('calls', CallController::class);
});
