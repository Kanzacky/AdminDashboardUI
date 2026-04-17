<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to dashboard
Route::redirect('/', '/dashboard');

// Auth pages (UI only)
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/forgot-password', [PageController::class, 'forgotPassword'])->name('forgot-password');

// Dashboard
Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

// User Management
Route::get('/users', [PageController::class, 'users'])->name('users');

// Role & Permission Management
Route::get('/roles', [PageController::class, 'roles'])->name('roles');
Route::get('/permissions', [PageController::class, 'permissions'])->name('permissions');

// Menu Management
Route::get('/menu-management', [PageController::class, 'menuManagement'])->name('menu-management');

// Analytics & Reports
Route::get('/analytics', [PageController::class, 'analytics'])->name('analytics');
Route::get('/reports', [PageController::class, 'reports'])->name('reports');

// Activity & Notifications
Route::get('/activity-log', [PageController::class, 'activityLog'])->name('activity-log');
Route::get('/notifications', [PageController::class, 'notifications'])->name('notifications');

// Settings & Profile
Route::get('/settings', [PageController::class, 'settings'])->name('settings');
Route::get('/profile', [PageController::class, 'profile'])->name('profile');

// Help & Support
Route::get('/help', [PageController::class, 'help'])->name('help');

// Error pages
Route::get('/error-404', [PageController::class, 'error404'])->name('error-404');
Route::get('/maintenance', [PageController::class, 'maintenance'])->name('maintenance');
