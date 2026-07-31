<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AiWarningController extends Controller {
    public function index() {
        return view('warnings.index', ['data' => \App\Models\AiWarning::latest()->get()]);
    }
    
}