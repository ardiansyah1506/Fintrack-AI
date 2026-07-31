<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AiMemoryController extends Controller {
    public function index() {
        return view('memories.index', ['data' => $this->service->getAll()]);
    }
    
    public function store(Request $request) {
        $this->service->create($request->all());
        return back()->with('success', 'Data berhasil ditambahkan.');
    }
    public function update(Request $request, $id) {
        $this->service->update($id, $request->all());
        return back()->with('success', 'Data berhasil diupdate.');
    }
    public function destroy($id) {
        $this->service->delete($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }
}