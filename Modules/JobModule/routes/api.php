<?php

use Illuminate\Support\Facades\Route;
use Modules\JobModule\Http\Controllers\JobPostController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/insert-job-post', [JobPostController::class, 'insert']);
});

Route::get('/get-job-post', [JobPostController::class, 'getPagination']);
Route::get('/get-job-post-detail', [JobPostController::class, 'getDetail']);
