<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/services', [ServiceController::class, 'index']);
Route::post('/services', [ServiceController::class, 'store']);
Route::get('/appointments', [AppointmentController::class, 'index']);
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
