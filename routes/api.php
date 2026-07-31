<?php

use App\Http\Controllers\Api\BotController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\StatisticController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REST API Routes for FinTrack AI (Single Source of Truth)
| All API route names are prefixed with 'api.' to avoid collisions with Web UI routes.
|--------------------------------------------------------------------------
*/

Route::name('api.')->group(function () {
    // Dashboard & Statistics
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics');

    // Category CRUD
    Route::apiResource('categories', CategoryController::class);

    // Transaction CRUD
    Route::apiResource('transactions', TransactionController::class);

    // Financial Reports
    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/daily', [ReportController::class, 'daily'])->name('daily');
        Route::get('/weekly', [ReportController::class, 'weekly'])->name('weekly');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
    });

    // n8n / Telegram Bot Integration Endpoint
    Route::post('/bot/execute', [BotController::class, 'execute'])->name('bot.execute');

    // Control Center API Endpoints
    Route::apiResource('reminders', \App\Http\Controllers\Api\ReminderController::class);
    Route::get('/bills', [\App\Http\Controllers\Api\RecurringBillController::class, 'index']);
    Route::get('/budget/summary', [\App\Http\Controllers\Api\BudgetController::class, 'summary']);
    Route::get('/saving-goals', [\App\Http\Controllers\Api\SavingGoalController::class, 'index']);
    Route::get('/dashboard/ai', [\App\Http\Controllers\Api\DashboardController::class, 'aiSummary']);
    Route::get('/insights', [\App\Http\Controllers\Api\AiInsightController::class, 'index']);
    Route::get('/notifications', [\App\Http\Controllers\Api\NotificationController::class, 'index']);
    Route::get('/telegram/status', [\App\Http\Controllers\Api\TelegramStatusController::class, 'index']);
});
