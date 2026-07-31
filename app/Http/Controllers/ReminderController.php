<?php
namespace App\Http\Controllers;

use App\Services\ReminderService;

class ReminderController extends Controller
{
    public function __construct(protected ReminderService $service) {}

    public function index()
    {
        return view('reminders.index', [
            'reminders' => $this->service->getAllReminders()
        ]);
    }
}
