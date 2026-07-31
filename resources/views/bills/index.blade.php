<x-app-layout title="Recurring Bills - Control Center">
    <x-slot name="header">Recurring Bills</x-slot>
    <div class="space-y-6 text-slate-800 font-sans">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Tagihan Rutin & Pengeluaran Tetap</h2>
                <p class="text-xs text-slate-400 mt-1">Setup tagihan yang otomatis diproses AI n8n setiap siklus tertentu.</p>
            </div>
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Tagihan
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($bills as $bill)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative group overflow-hidden hover:shadow-md transition">
                <div class="absolute top-0 right-0 w-2 h-full {{ $bill->status == 'active' ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-600 flex justify-center items-center">
                        <i class="fa-solid fa-file-invoice text-xl"></i>
                    </div>
                    <span class="px-2 py-1 text-[10px] font-bold rounded-lg border border-slate-200 text-slate-500">
                        <i class="fa-solid fa-rotate mr-1"></i> {{ strtoupper($bill->repeat) }}
                    </span>
                </div>
                <h3 class="font-bold text-lg text-slate-800">{{ $bill->name }}</h3>
                <p class="text-xs text-slate-400">Kategori: {{ $bill->category }}</p>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-400 font-semibold mb-1">Nominal</p>
                        <p class="font-bold text-emerald-600 text-lg">Rp {{ number_format($bill->amount, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white p-8 rounded-3xl text-center shadow-sm text-slate-400">
                Data tagihan rutin masih kosong.
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
