<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AiWarningRequest;
use App\Services\AiWarningService;
class AiWarningController extends Controller {
    public function __construct(protected AiWarningService $service) {}
    public function index(Request $request) {
        return view('warnings.index', ['warnings' => $this->service->getAll($request->only('search'), 10)]);
    }
    public function store(AiWarningRequest $request) { $this->service->create($request->validated()); return back()->with('success', 'Data tersimpan.'); }
    public function update(AiWarningRequest $request, $id) { $this->service->update($id, $request->validated()); return back()->with('success', 'Data terupdate.'); }
    public function destroy($id) { $this->service->delete($id); return back()->with('success', 'Data terhapus.'); }
}