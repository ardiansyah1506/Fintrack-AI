<x-app-layout title="Saving Goals - Control Center">
    <x-slot name="header">Target Tabungan</x-slot>
    <div class="space-y-6 text-slate-800 font-sans">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Target \& Tujuan Tabungan</h2>
                <p class="text-xs text-slate-400 mt-1">Rencanakan keuangan masa depan dan lacak progres pencapaian.</p>
            </div>
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Target Baru
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($goals as $goal)
            @php
                $percent = $goal->target_amount > 0 ? min(100, round(($goal->current_amount / $goal->target_amount) * 100)) : 0;
            @endphp
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col gap-4">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex justify-center items-center text-xl">
                            <i class="{{ $goal->icon ?? 'fa-solid fa-bullseye' }}"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-800">{{ $goal->title }}</h3>
                            <p class="text-xs text-slate-400">Deadline: {{ $goal->deadline ? date('d M Y', strtotime($goal->deadline)) : 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm text-slate-700 font-bold mb-2">
                        <span>Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span>
                        <span>Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3.5">
                        <div class="bg-emerald-500 h-3.5 rounded-full" style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="text-right mt-1">
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">{{ $percent }}%</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white p-8 rounded-3xl text-center shadow-sm text-slate-400">
                Belum ada target tabungan yang ditambahkan.
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
