<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiCenterController extends Controller
{
    /**
     * Display the main AI Center dashboard
     */
    public function index()
    {
        return view('ai-center.index', [
            'header' => 'AI Center',
            'breadcrumb' => 'Monitoring AI n8n & Gemini'
        ]);
    }
}
