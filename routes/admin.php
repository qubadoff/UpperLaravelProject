<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApplianceController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin')->group(function (): void {
    Route::get('', DashboardController::class)->name('dashboard');
    Route::resource('admins', AdminController::class)->except('show');
    Route::resource('appliances', ApplianceController::class)->except('show');
    Route::resource('brands', BrandController::class)->except('show');
    Route::resource('fees', FeeController::class)->except('show');
    Route::delete('logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('payments', PaymentController::class)->except(['show', 'edit', 'update']);
    Route::get('profile', [ProfileController::class, 'profileView'])->name('profile.view');
    Route::patch('profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('reports/revenue', [ReportController::class, 'showTicketRevenueReport'])->name('reports.revenue');
    Route::get('tickets/{ticket}/deposit', [TicketController::class, 'deposit'])->name('tickets.deposit');
    Route::resource('tickets', TicketController::class);
    Route::resource('users', UserController::class);
});

Route::middleware('guest:admin')->group(function (): void {
    Route::get('login', [AuthController::class, 'loginView'])->name('login.view');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
