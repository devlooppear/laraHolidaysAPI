<?php

use App\Http\Controllers\HolidayPlanController;
use App\Http\Controllers\HolidayPlanLogController;
use App\Http\Controllers\ParticipantsGroupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('users', [UserController::class, 'store']);

Route::get('generate-pdf/{id}', [HolidayPlanController::class, 'generatePdf'])->name('generate-pdf');

Route::middleware('auth:api')->group(function () {
    // User Routes
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::post('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);

    // Holiday Plan Routes
    Route::get('holiday-plans', [HolidayPlanController::class, 'index']);
    Route::post('holiday-plans', [HolidayPlanController::class, 'store']);
    Route::get('holiday-plans/{id}', [HolidayPlanController::class, 'show']);
    Route::post('holiday-plans/{id}', [HolidayPlanController::class, 'update']);
    Route::delete('holiday-plans/{id}', [HolidayPlanController::class, 'destroy']);

    // Holiday Plan Log Routes
    Route::get('holiday-plan-logs', [HolidayPlanLogController::class, 'index']);
    Route::get('holiday-plan-logs/{id}', [HolidayPlanLogController::class, 'show']);
    Route::delete('holiday-plan-logs/{id}', [HolidayPlanLogController::class, 'destroy']);

    // Participants Group Routes
    Route::get('participants-groups', [ParticipantsGroupController::class, 'index']);
    Route::get('participants-groups/{id}', [ParticipantsGroupController::class, 'show']);
    Route::post('participants-groups', [ParticipantsGroupController::class, 'store']);
    Route::post('participants-groups/{id}', [ParticipantsGroupController::class, 'update']);
    Route::delete('participants-groups/{id}', [ParticipantsGroupController::class, 'destroy']);
});
