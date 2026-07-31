<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AiRecommendationController extends Controller {
    public function index() {
        return view('recommendations.index', ['data' => \App\Models\AiRecommendation::latest()->get()]);
    }
    
}