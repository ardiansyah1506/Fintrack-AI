<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes for FinTrack AI
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Category CRUD
Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);

// Transaction CRUD
Route::resource('transactions', TransactionController::class)->except(['create', 'edit', 'show']);

// Financial Reports
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

// Settings
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

// Control Center UI
Route::resource('reminders', \App\Http\Controllers\ReminderController::class);
Route::resource('bills', \App\Http\Controllers\RecurringBillController::class);
Route::resource('budgets', \App\Http\Controllers\BudgetController::class);
Route::resource('saving-goals', \App\Http\Controllers\SavingGoalController::class);
Route::get('/ai-center', [\App\Http\Controllers\AiCenterController::class, 'index'])->name('ai-center.index');
Route::resource('notifications', \App\Http\Controllers\NotificationController::class);
Route::get('/telegram', [\App\Http\Controllers\TelegramConfigController::class, 'index'])->name('telegram.config');
