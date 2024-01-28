<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Technicians\TechnicianController;


Route::middleware('guest:web')->prefix('technicians')->group(function (){
    Route::get('/login', [TechnicianController::class, 'login'])->name('technician.login');
    Route::post('/loginPost', [TechnicianController::class, 'loginPost'])->name('technician.loginPost');
});

Route::middleware('auth:web')->prefix('technicians')->group(function () {
    Route::get('/dashboard', [TechnicianController::class, 'dashboard'])->name('technician.dashboard');
    Route::get('/logout', [TechnicianController::class, 'logout'])->name('technician.logout');
});
