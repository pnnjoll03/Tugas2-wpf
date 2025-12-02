<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SalaryController;
use Illuminate\Support\Facades\Route;

// Public routes (tanpa login)
Route::get('/', function () {
    return redirect('/login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']); // HAPUS ->name('login.post')
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']); // HAPUS ->name('register.post')
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes dengan closure middleware
Route::middleware(['web'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        // Cek session
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        return $next($request);
    }], function () {
        
        // Employee routes
        Route::resource('employees', EmployeeController::class);
        
        // Department routes
        Route::resource('departments', DepartmentController::class);
        
        // Position routes
        Route::resource('positions', PositionController::class);
        
        // Salary routes - HANYA YANG DIPERLUKAN
        Route::get('/salaries', [SalaryController::class, 'index'])->name('salaries.index');
        Route::get('/salaries/create', [SalaryController::class, 'create'])->name('salaries.create');
        Route::post('/salaries', [SalaryController::class, 'store'])->name('salaries.store');
        Route::get('/salaries/{salary}/edit', [SalaryController::class, 'edit'])->name('salaries.edit');
        Route::put('/salaries/{salary}', [SalaryController::class, 'update'])->name('salaries.update');
        Route::delete('/salaries/{salary}', [SalaryController::class, 'destroy'])->name('salaries.destroy');
        
        // Attendance routes - HANYA YANG DIPERLUKAN
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
        Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::get('/attendances/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
        Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
        Route::delete('/attendances/{attendance}', [AttendanceController::class, 'destroy'])->name('attendances.destroy');
    });
});