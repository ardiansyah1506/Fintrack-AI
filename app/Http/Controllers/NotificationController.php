<?php
namespace App\Http\Controllers;

use App\Services\NotificationService;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $service) {}

    public function index()
    {
        return view('notifications.index', [
            'notifications' => $this->service->getAllNotifications()
        ]);
    }
}
