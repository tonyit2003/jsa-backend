<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminModule\Http\Controllers\UserCandidateController;
use Modules\AdminModule\Http\Controllers\UserRecruitersController;

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

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('adminmodule', AdminModuleController::class)->names('adminmodule');
// });

// Candidate routes
Route::get('/userCandidate', [UserCandidateController::class, 'index']);
Route::delete('/delete-user-candidate/{id}', [UserCandidateController::class, 'delete']);

// Recruiter routes
Route::get('/userRecruiter', [UserRecruitersController::class, 'index']);