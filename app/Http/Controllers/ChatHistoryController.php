<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\ChatHistoryService;
class ChatHistoryController extends Controller {
    public function __construct(protected ChatHistoryService $service) {}
    public function index(Request $request) {
        return view('chat-histories.index', ['chat_histories' => $this->service->getAll($request->only('search'), 10)]);
    }
}