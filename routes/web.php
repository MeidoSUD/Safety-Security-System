<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InternalRequestController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MembershipController;

// Public Website Routes
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/services', function () {
    return view('pages.services');
})->name('services');

Route::get('/sectors', function () {
    return view('pages.sectors');
})->name('sectors');

Route::get('/erp-system', function () {
    return view('pages.erp');
})->name('erp');

Route::get('/request-membership', function () {
    return view('pages.membership');
})->name('membership');

Route::post('/request-membership', [MembershipController::class, 'store'])->name('membership.store');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Authentication & Role Switching
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/switch-role', [AuthController::class, 'switchRole'])->name('switch.role');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Direct Route Alias for /dashboard (fixes route('dashboard') calls)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ERP Dashboard Routes (Protected Structure)
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts');
    Route::get('/visits', [VisitController::class, 'index'])->name('visits');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/internal-requests', [InternalRequestController::class, 'index'])->name('internal_requests');
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships');
});
