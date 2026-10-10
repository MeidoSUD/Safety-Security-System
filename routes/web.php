<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InternalRequestController;
use App\Http\Controllers\NotificationController;
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

// Authentication & Demo Fast-Role Switcher
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/switch-role', [AuthController::class, 'switchRole'])->name('switch.role');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Direct Route Alias
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ERP Dashboard Routes
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    
    // Facilities & Client Sites
    Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities');
    Route::post('/facilities', [FacilityController::class, 'store'])->name('facilities.store');

    // Contracts
    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');

    // Maintenance Requests
    Route::get('/maintenance-requests', [MaintenanceRequestController::class, 'index'])->name('maintenance_requests.index');
    Route::post('/maintenance-requests', [MaintenanceRequestController::class, 'store'])->name('maintenance_requests.store');
    Route::post('/maintenance-requests/{id}/convert-to-visit', [MaintenanceRequestController::class, 'convertToVisit'])->name('maintenance_requests.convert');

    // Visits & Field Engineering Execution
    Route::get('/visits', [VisitController::class, 'index'])->name('visits');
    Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
    Route::get('/visits/{id}/manage', [VisitController::class, 'manage'])->name('visits.manage');
    Route::post('/visits/{id}/upload-image', [VisitController::class, 'uploadImage'])->name('visits.upload_image');
    Route::post('/visits/{id}/add-item', [VisitController::class, 'addItem'])->name('visits.add_item');
    Route::delete('/visits/{id}/items/{itemId}', [VisitController::class, 'deleteItem'])->name('visits.delete_item');
    Route::post('/visits/{id}/update-status', [VisitController::class, 'updateStatus'])->name('visits.update_status');
    Route::post('/visits/{id}/toggle-reminder', [VisitController::class, 'toggleReminder'])->name('visits.toggle_reminder');

    // Safety Inspection Reports & Certificates
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{id}/approve', [ReportController::class, 'approve'])->name('reports.approve');

    // Inter-Departmental Requests
    Route::get('/internal-requests', [InternalRequestController::class, 'index'])->name('internal_requests');
    Route::post('/internal-requests', [InternalRequestController::class, 'store'])->name('internal_requests.store');
    Route::post('/internal-requests/{id}/status', [InternalRequestController::class, 'updateStatus'])->name('internal_requests.status');

    // Notifications & Reminders
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read_all');

    // SaaS Configuration & Tenant Selling Settings
    Route::get('/saas-settings', [CompanyController::class, 'index'])->name('saas_settings');
    Route::post('/saas-settings/{id}', [CompanyController::class, 'update'])->name('saas_settings.update');

    // Legacy / Permissions & Memberships
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships');
});
