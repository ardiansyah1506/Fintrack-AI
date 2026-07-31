<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AiAchievementRequest;
use App\Services\AiAchievementService;
class AiAchievementController extends Controller {
    public function __construct(protected AiAchievementService $service) {}
    public function index(Request $request) {
        return view('achievements.index', ['achievements' => $this->service->getAll($request->only('search'), 10)]);
    }
    public function store(AiAchievementRequest $request) { $this->service->create($request->validated()); return back()->with('success', 'Data tersimpan.'); }
    public function update(AiAchievementRequest $request, $id) { $this->service->update($id, $request->validated()); return back()->with('success', 'Data terupdate.'); }
    public function destroy($id) { $this->service->delete($id); return back()->with('success', 'Data terhapus.'); }
}