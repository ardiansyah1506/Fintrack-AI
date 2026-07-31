<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\PromptRequest;
use App\Services\PromptService;
class PromptController extends Controller {
    public function __construct(protected PromptService $service) {}
    public function index(Request $request) {
        return view('prompts.index', ['prompts' => $this->service->getAll($request->only('search'), 10)]);
    }
    public function store(PromptRequest $request) { $this->service->create($request->validated()); return back()->with('success', 'Data tersimpan.'); }
    public function update(PromptRequest $request, $id) { $this->service->update($id, $request->validated()); return back()->with('success', 'Data terupdate.'); }
    public function destroy($id) { $this->service->delete($id); return back()->with('success', 'Data terhapus.'); }
}