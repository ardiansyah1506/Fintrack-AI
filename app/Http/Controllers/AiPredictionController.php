<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AiPredictionController extends Controller {
    public function index() {
        return view('predictions.index', ['data' => \App\Models\AiPrediction::latest()->get()]);
    }
    
}