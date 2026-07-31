<?php

namespace App\Services;

use InvalidArgumentException;
use App\Intents\Contracts\IntentInterface;

class IntentDispatcherService
{
    /**
     * Map string intent to the specific Intent Handler Class.
     */
    protected array $intentMap = [
        // Transaction Module
        'create_transaction' => \App\Intents\Transactions\CreateTransactionIntent::class,
        'update_transaction' => \App\Intents\Transactions\UpdateTransactionIntent::class,
        'delete_transaction' => \App\Intents\Transactions\DeleteTransactionIntent::class,
        
        // Statistics & Reports Module
        'statistics' => \App\Intents\Statistics\StatisticsIntent::class,
        'daily_report' => \App\Intents\Statistics\ReportIntent::class,
        'weekly_report' => \App\Intents\Statistics\ReportIntent::class,
        'monthly_report' => \App\Intents\Statistics\ReportIntent::class,
        'yearly_report' => \App\Intents\Statistics\ReportIntent::class,
        
        // Reminder Module
        'create_reminder' => \App\Intents\Reminders\CreateReminderIntent::class,
        'update_reminder' => \App\Intents\Reminders\UpdateReminderIntent::class,
        'delete_reminder' => \App\Intents\Reminders\DeleteReminderIntent::class,
        'list_reminders' => \App\Intents\Reminders\ListRemindersIntent::class,
        
        // Recurring Bills Module
        'create_bill' => \App\Intents\Bills\CreateBillIntent::class,
        'update_bill' => \App\Intents\Bills\UpdateBillIntent::class,
        'delete_bill' => \App\Intents\Bills\DeleteBillIntent::class,
        'list_bills' => \App\Intents\Bills\ListBillsIntent::class,
        
        // Budget Module
        'create_budget' => \App\Intents\Budgets\CreateBudgetIntent::class,
        'update_budget' => \App\Intents\Budgets\UpdateBudgetIntent::class,
        'delete_budget' => \App\Intents\Budgets\DeleteBudgetIntent::class,
        'budget' => \App\Intents\Budgets\BudgetSummaryIntent::class,
        'balance' => \App\Intents\Budgets\BudgetSummaryIntent::class,
        
        // Saving Goals Module
        'create_saving_goal' => \App\Intents\SavingGoals\CreateSavingGoalIntent::class,
        'update_saving_goal' => \App\Intents\SavingGoals\UpdateSavingGoalIntent::class,
        'delete_saving_goal' => \App\Intents\SavingGoals\DeleteSavingGoalIntent::class,
        'saving_progress' => \App\Intents\SavingGoals\SavingProgressIntent::class,
        
        // AI Module
        'ai_insight' => \App\Intents\Ai\AiInsightIntent::class,
        'ai_prediction' => \App\Intents\Ai\AiPredictionIntent::class,
        'ai_recommendation' => \App\Intents\Ai\AiRecommendationIntent::class,
        
        // Notifications Module
        'list_notifications' => \App\Intents\Notifications\ListNotificationsIntent::class,
        'read_notification' => \App\Intents\Notifications\ReadNotificationIntent::class,
        
        // Memory Module
        'save_memory' => \App\Intents\Memories\SaveMemoryIntent::class,
        'delete_memory' => \App\Intents\Memories\DeleteMemoryIntent::class,
        'list_memories' => \App\Intents\Memories\ListMemoriesIntent::class,
        
        // Prompt Module
        'list_prompts' => \App\Intents\Prompts\ListPromptsIntent::class,
        
        // System Module
        'telegram_status' => \App\Intents\System\TelegramStatusIntent::class,
        'dashboard_summary' => \App\Intents\System\DashboardSummaryIntent::class,
        
        // Tools 
        'help' => \App\Intents\System\HelpIntent::class,
    ];

    /**
     * Dispatch the intent dynamically via IoC Container resolution.
     * 
     * @param string $intentString
     * @param array $parameters
     * @return array
     * @throws InvalidArgumentException
     */
    public function dispatch(string $intentString, array $parameters = []): array
    {
        $intentName = strtolower(trim($intentString));
        
        // Add implicit intent injection into parameters for handlers that share the same class (like ReportIntent)
        $parameters['_active_intent'] = $intentName;
        
        if (!isset($this->intentMap[$intentName])) {
            throw new InvalidArgumentException("Intent '{$intentName}' tidak terdaftar pada Intent Dispatcher Engine.");
        }
        
        $intentClass = $this->intentMap[$intentName];
        
        // Fallback safety checking before instantiation
        if (!class_exists($intentClass)) {
            return [
                'status' => 'error',
                'message' => "Modul untuk intent '{$intentName}' ({$intentClass}) sedang dalam tahap konstruksi."
            ];
        }

        /** @var IntentInterface $intentHandler */
        $intentHandler = app()->make($intentClass);
        
        return $intentHandler->handle($parameters);
    }
}
