<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatHistory;
use App\Http\Requests\StoreChatHistoryRequest;
use App\Http\Requests\UpdateChatHistoryRequest;

class ChatHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ChatHistory $chatHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatHistoryRequest $request, ChatHistory $chatHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChatHistory $chatHistory)
    {
        //
    }
}
