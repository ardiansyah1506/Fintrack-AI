<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AiAchievementController extends Controller {
    public function index() {
        return view('achievements.index', ['data' => $this->service->getAll()]);
    }
    
}