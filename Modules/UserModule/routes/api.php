<?php

use Illuminate\Support\Facades\Route;
use Modules\UserModule\Http\Controllers\UserCandidateController;
use Modules\UserModule\Http\Controllers\AuthController;
use Modules\UserModule\Http\Controllers\UserController;
use Modules\UserModule\Http\Controllers\UserRecruitersController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/getUser', [AuthController::class, 'getUser']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/get-company-information', [UserRecruitersController::class, 'getInformation']);
    Route::post('/update-company-information', [UserRecruitersController::class, 'updateInformation']);

    Route::get('/get-candidate-information', [UserCandidateController::class, 'getInformation']);
    Route::post('/update-candidate-information', [UserCandidateController::class, 'updateInformation']);

    Route::post('/update-information', [UserController::class, 'updateInformation']);
});
