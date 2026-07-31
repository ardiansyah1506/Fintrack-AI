<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// We skip specific Request/Resource for brevity since they are internal API calls, 
// or use normal request validate if FormRequests are unverified.
use App\Services\ReminderService;

class ReminderController extends Controller
{
    protected $service;

    public function __construct(ReminderService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(['data' => $this->service->getAllReminders()]);
    }

    public function store(Request $request)
    {
        return response()->json(['data' => $this->service->createReminder($request->all())]);
    }

    public function update(Request $request, string $id)
    {
        return response()->json(['data' => $this->service->updateReminder($id, $request->all())]);
    }

    public function destroy(string $id)
    {
        $this->service->deleteReminder($id);
        return response()->json(['message' => 'deleted']);
    }
}
