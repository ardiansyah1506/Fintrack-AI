<x-app-layout title="Budgets - Control Center">
    <x-slot name="header">Budgets</x-slot>
    
    <div x-data="{ showModal: false, editMode: false, currentId: null, form: { category: '', amount: '', period: 'monthly' } }" class="space-y-6 text-slate-800 font-sans relative">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Manajemen Anggaran</h2>
                <p class="text-xs text-slate-400 mt-1">Atur pagu pengeluaran agar stabil.</p>
            </div>
            <button @click="showModal = true; editMode = false; form = { category: '', amount: '', period: 'monthly' }" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Anggaran
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Jumlah Target</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80 text-slate-700">
                    @forelse($budgets as $budget)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-medium">{{ $budget->category }}</td>
                        <td class="px-6 py-4 font-bold text-emerald-600">Rp {{ number_format($budget->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg border bg-slate-50 text-slate-600 border-slate-200">
                                {{ strtoupper($budget->period) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="showModal = true; editMode = true; currentId = {{ $budget->id }}; form = { category: '{{ addslashes($budget->category) }}', amount: '{{ $budget->amount }}', period: '{{ $budget->period }}' }" class="text-indigo-600 hover:text-indigo-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('budgets', $budget->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus pagu anggaran ini?')" class="text-rose-600 hover:text-rose-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada pagu pengeluaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Alpine Modal -->
        <div x-show="showModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showModal = false"></div>
            <div class="bg-white rounded-3xl p-6 w-full max-w-lg z-10 shadow-2xl relative" x-transition>
                <button @click="showModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                <h3 class="text-lg font-bold text-slate-800 mb-4" x-text="editMode ? 'Edit Budget' : 'Tambah Budget Baru'"></h3>
                
                <form :action="editMode ? '{{ url('budgets') }}/' + currentId : '{{ route('budgets.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kategori Pengeluaran</label>
                        <input type="text" name="category" x-model="form.category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50" required placeholder="Contoh: Makan, Bensin">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Batas Pengeluaran (Rp)</label>
                        <input type="number" name="amount" x-model="form.amount" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50" required placeholder="Contoh: 1500000">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Periode</label>
                        <select name="period" x-model="form.period" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <option value="weekly">Mingguan</option>
                            <option value="monthly">Bulanan</option>
                            <option value="yearly">Tahunan</option>
                        </select>
                    </div>
                    
                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-xl font-semibold text-slate-500 hover:bg-slate-100 transition">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
