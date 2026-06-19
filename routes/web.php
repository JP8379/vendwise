<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SupportTicketController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\SystemLogController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\SystemSettingController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');

// Footer Pages
Route::view('/about',       'pages.about')->name('about');
Route::view('/features',    'pages.features')->name('features');
Route::view('/role-system', 'pages.roles')->name('roles');
Route::view('/privacy',     'pages.privacy')->name('privacy');
Route::view('/terms',       'pages.terms')->name('terms');
Route::view('/contact',     'pages.contact')->name('contact');

/*
|--------------------------------------------------------------------------
| User Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Transactions
    Route::get('/transactions',         [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create',  [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions',        [TransactionController::class, 'store'])->name('transactions.store');

    // Inventory
    Route::get('/inventory',        [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory',       [InventoryController::class, 'store'])->name('inventory.store');

    // Reports — Daily, Weekly, Monthly, Yearly
    Route::get('/reports/{period?}', [ReportController::class, 'index'])
        ->where('period', 'daily|weekly|monthly|yearly')
        ->name('reports.index');

    Route::post('/reports/{period}/pdf', [ReportController::class, 'generatePDF'])
        ->where('period', 'daily|weekly|monthly|yearly')
        ->name('reports.pdf');

    // Vendor Support
    Route::get('/support',  [SupportTicketController::class, 'index'])->name('support.index');
    Route::post('/support', [SupportTicketController::class, 'store'])->name('support.store');

    // Notifications
    Route::get('/notifications',                  [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read',   [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');

    // Settings
    Route::get('/settings',                    [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/profile',           [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/settings/business',          [SettingsController::class, 'updateBusiness'])->name('settings.business.update');
    Route::post('/settings/password',          [SettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::delete('/settings/delete-account',  [SettingsController::class, 'destroy'])->name('settings.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::get('/users',                                        [UserManagementController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/toggle-status',                 [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::patch('/users/{user}/approve-deletion-request',      [UserManagementController::class, 'approveDeletionRequest'])->name('users.approve-deletion-request');
        Route::patch('/users/{user}/reject-deletion-request',       [UserManagementController::class, 'rejectDeletionRequest'])->name('users.reject-deletion-request');

        // System Logs
        Route::get('/logs', [SystemLogController::class, 'index'])->name('logs.index');

        // Support Inbox
        Route::get('/support',              [SupportController::class, 'index'])->name('support.index');
        Route::post('/support/{id}/reply',  [SupportController::class, 'reply'])->name('support.reply');
        Route::post('/support/{id}/resolve',[SupportController::class, 'resolve'])->name('support.resolve');

        // System Settings
        Route::get('/settings',  [SystemSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SystemSettingController::class, 'update'])->name('settings.update');
    });

require __DIR__ . '/auth.php';