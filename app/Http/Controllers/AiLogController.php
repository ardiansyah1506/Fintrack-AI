<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AiLogController extends Controller {
    public function index() {
        return view('ai-logs.index', ['data' => $this->service->getAll()]);
    }
    
}