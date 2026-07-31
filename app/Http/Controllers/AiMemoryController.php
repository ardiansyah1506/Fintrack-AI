<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AiMemoryController extends Controller {
    public function index() {
        return view('memories.index', ['data' => \App\Models\AiMemory::latest()->get()]);
    }
    
    public function store(Request $request) {
        \App\Models\AiMemory::create($request->all());
        return back()->with('success', 'Data berhasil ditambahkan.');
    }
    public function update(Request $request, $id) {
        \App\Models\AiMemory::findOrFail($id)->update($request->all());
        return back()->with('success', 'Data berhasil diupdate.');
    }
    public function destroy($id) {
        \App\Models\AiMemory::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}