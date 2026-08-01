<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables affected by title to name renaming.
     */
    protected array $tables = [
        'reminders',
        'saving_goals',
        'ai_insights',
        'notifications',
        'ai_predictions',
        'ai_recommendations',
        'ai_warnings',
        'ai_achievements',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'title') && !Schema::hasColumn($tableName, 'name')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->renameColumn('title', 'name');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'name') && !Schema::hasColumn($tableName, 'title')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->renameColumn('name', 'title');
                });
            }
        }
    }
};
