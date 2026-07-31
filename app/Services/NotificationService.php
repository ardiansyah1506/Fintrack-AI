<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class NotificationService
{
    public function getAllNotifications(): Collection
    {
        return Notification::orderBy('created_at', 'desc')->get();
    }

    public function getUnreadNotifications(): Collection
    {
        return Notification::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    }

    public function createNotification(array $data): Notification
    {
        return Notification::create($data);
    }

    public function markAsRead($id): Notification
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read_at' => Carbon::now()]);
        return $notification;
    }

    public function markAllAsRead(): void
    {
        Notification::whereNull('read_at')->update(['read_at' => Carbon::now()]);
    }
}
