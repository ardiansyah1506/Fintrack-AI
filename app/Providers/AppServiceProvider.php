<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Contracts\Repositories\TransactionRepositoryInterface::class, \App\Repositories\Eloquent\TransactionRepository::class);
        $this->app->bind(\App\Contracts\Repositories\CategoryRepositoryInterface::class, \App\Repositories\Eloquent\CategoryRepository::class);
        $this->app->bind(\App\Contracts\Repositories\BudgetRepositoryInterface::class, \App\Repositories\Eloquent\BudgetRepository::class);
        $this->app->bind(\App\Contracts\Repositories\ReminderRepositoryInterface::class, \App\Repositories\Eloquent\ReminderRepository::class);
        $this->app->bind(\App\Contracts\Repositories\RecurringBillRepositoryInterface::class, \App\Repositories\Eloquent\RecurringBillRepository::class);
        $this->app->bind(\App\Contracts\Repositories\SavingGoalRepositoryInterface::class, \App\Repositories\Eloquent\SavingGoalRepository::class);
        $this->app->bind(\App\Contracts\Repositories\NotificationRepositoryInterface::class, \App\Repositories\Eloquent\NotificationRepository::class);
        $this->app->bind(\App\Contracts\Repositories\PromptRepositoryInterface::class, \App\Repositories\Eloquent\PromptRepository::class);
        $this->app->bind(\App\Contracts\Repositories\AiMemoryRepositoryInterface::class, \App\Repositories\Eloquent\AiMemoryRepository::class);
        $this->app->bind(\App\Contracts\Repositories\AiLogRepositoryInterface::class, \App\Repositories\Eloquent\AiLogRepository::class);
        $this->app->bind(\App\Contracts\Repositories\ChatHistoryRepositoryInterface::class, \App\Repositories\Eloquent\ChatHistoryRepository::class);
        $this->app->bind(\App\Contracts\Repositories\AiPredictionRepositoryInterface::class, \App\Repositories\Eloquent\AiPredictionRepository::class);
        $this->app->bind(\App\Contracts\Repositories\AiRecommendationRepositoryInterface::class, \App\Repositories\Eloquent\AiRecommendationRepository::class);
        $this->app->bind(\App\Contracts\Repositories\AiWarningRepositoryInterface::class, \App\Repositories\Eloquent\AiWarningRepository::class);
        $this->app->bind(\App\Contracts\Repositories\AiAchievementRepositoryInterface::class, \App\Repositories\Eloquent\AiAchievementRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
