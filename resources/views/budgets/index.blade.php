<x-app-layout title="Budgeting - Control Center">
    <x-slot name="header">Budget Monitoring</x-slot>
    <div class="space-y-6 text-slate-800 font-sans">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Alokasi Budget per Kategori</h2>
                <p class="text-xs text-slate-400 mt-1">Status dan persentase penggunaan budget bulanan berbasis klasifikasi transaksi.</p>
            </div>
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Budget
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            @forelse($budgets as $budget)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <div class="flex justify-between items-start mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-600 flex justify-center items-center font-bold">
                            {{ substr($budget['category'], 0, 1) }}
                        </div>
                        <h3 class="font-bold text-lg text-slate-800">{{ $budget['category'] }}</h3>
                    </div>
                    <span class="px-2 py-1 text-xs font-bold rounded-lg bg-{{ $budget['status_color'] }}-50 text-{{ $budget['status_color'] }}-600">
                        {{ $budget['percentage'] }}% Terpakai
                    </span>
                </div>
                
                <div class="space-y-2">
                    <div class="flex justify-between text-xs text-slate-500 font-medium">
                        <span>Terpakai: Rp {{ number_format($budget['spent'], 0, ',', '.') }}</span>
                        <span>Sisa: Rp {{ number_format($budget['remaining'], 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3">
                        <div class="bg-{{ $budget['status_color'] }}-500 h-3 rounded-full" style="width: {{ $budget['percentage'] }}%"></div>
                    </div>
                    <p class="text-[10px] text-right text-slate-400 mt-1">Tipe: Pengeluaran • Pagu: Rp {{ number_format($budget['amount'], 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white p-8 rounded-3xl text-center shadow-sm text-slate-400">
                Belum ada data perencanaan budget.
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
