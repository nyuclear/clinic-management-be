<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentNotificationMail;
use App\Models\Appointment;
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::post('/users', [UserController::class, 'create']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);

    Route::get('/patients', [PatientController::class, 'index']);

    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::post('/appointments', [AppointmentController::class, 'create']);

    Route::get('/test-gmail', function () {
      
        try {
            $appointment = App\Models\Appointment::first();
            if (!$appointment) return 'Appointment not found';
    
            Mail::to('ntqn960607@gmail.com')->send(new AppointmentNotificationMail($appointment));
            return 'Mail sent!';
        } catch (\Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
            return 'Mail sending failed: ' . $e->getMessage();
        }
    });
});
