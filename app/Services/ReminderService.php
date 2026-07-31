<?php

namespace App\Services;

use App\Models\Reminder;
use Illuminate\Database\Eloquent\Collection;

class ReminderService
{
    public function getAllReminders(): Collection
    {
        return Reminder::orderBy('due_date', 'asc')->get();
    }

    public function createReminder(array $data): Reminder
    {
        return Reminder::create($data);
    }

    public function updateReminder($id, array $data): Reminder
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->update($data);
        return $reminder;
    }

    public function deleteReminder($id): void
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->delete();
    }
}
