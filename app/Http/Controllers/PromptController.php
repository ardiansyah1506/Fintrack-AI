<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class PromptController extends Controller {
    public function index() {
        return view('prompts.index', ['data' => \App\Models\Prompt::latest()->get()]);
    }
    
    public function store(Request $request) {
        \App\Models\Prompt::create($request->all());
        return back()->with('success', 'Data berhasil ditambahkan.');
    }
    public function update(Request $request, $id) {
        \App\Models\Prompt::findOrFail($id)->update($request->all());
        return back()->with('success', 'Data berhasil diupdate.');
    }
    public function destroy($id) {
        \App\Models\Prompt::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}