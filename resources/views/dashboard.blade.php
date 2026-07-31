<x-app-layout title="Control Center - FinTrack AI">
    <x-slot name="header">Control Center</x-slot>

    <div class="space-y-6 text-slate-800 font-sans">
        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-3 mb-6">
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Transaksi
            </button>
            <button class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-bell mr-2"></i> Tambah Reminder
            </button>
            <button class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-wallet mr-2"></i> Tambah Budget
            </button>
            <button class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-bullseye mr-2"></i> Tambah Target
            </button>
        </div>
        
        <!-- Summary Widgets -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            <x-card padding="false" class="rounded-3xl shadow-sm border-0 bg-white">
                <div class="p-5">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Saldo</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-2">Rp 12.000.000</h3>
                </div>
            </x-card>
            <x-card padding="false" class="rounded-3xl shadow-sm border-0 bg-white">
                <div class="p-5">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Income</p>
                    <h3 class="text-2xl font-bold text-emerald-500 mt-2">Rp 15.000.000</h3>
                </div>
            </x-card>
            <x-card padding="false" class="rounded-3xl shadow-sm border-0 bg-white">
                <div class="p-5">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Expense</p>
                    <h3 class="text-2xl font-bold text-rose-500 mt-2">Rp 3.000.000</h3>
                </div>
            </x-card>
            <x-card padding="false" class="rounded-3xl shadow-sm border-0 bg-white">
                <div class="p-5">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Bills Due</p>
                    <h3 class="text-2xl font-bold text-amber-500 mt-2">2 Tagihan</h3>
                </div>
            </x-card>
            <x-card padding="false" class="rounded-3xl shadow-sm border-0 bg-white">
                <div class="p-5">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Reminder Today</p>
                    <h3 class="text-2xl font-bold text-indigo-500 mt-2">1 Tugas</h3>
                </div>
            </x-card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Budget Progress -->
            <x-card title="Budget Progress" class="rounded-3xl shadow-sm border-0 bg-white" padding="false">
                 <div class="p-6 space-y-5">
                     <div>
                         <div class="flex justify-between text-sm text-slate-700 font-medium mb-2">
                             <span>Makanan</span>
                             <span class="text-emerald-500">Sisa Rp1.500.000 (75%)</span>
                         </div>
                         <div class="w-full bg-slate-100 rounded-full h-3">
                             <div class="bg-emerald-400 h-3 rounded-full" style="width: 25%"></div>
                         </div>
                     </div>
                     <div>
                         <div class="flex justify-between text-sm text-slate-700 font-medium mb-2">
                             <span>Transportasi</span>
                             <span class="text-amber-500">Sisa Rp100.000 (20%)</span>
                         </div>
                         <div class="w-full bg-slate-100 rounded-full h-3">
                             <div class="bg-amber-400 h-3 rounded-full" style="width: 80%"></div>
                         </div>
                     </div>
                 </div>
            </x-card>
            
            <!-- Saving Goal Progress -->
            <x-card title="Saving Goal Progress" class="rounded-3xl shadow-sm border-0 bg-white" padding="false">
                 <div class="p-6 space-y-5">
                     <div>
                         <div class="flex justify-between text-sm text-slate-700 font-medium mb-2">
                             <span class="flex items-center gap-2"><i class="fa-solid fa-plane text-slate-400"></i> Liburan Jepang</span>
                             <span class="text-emerald-500 text-xs font-bold bg-emerald-50 px-2 py-1 rounded-lg">60% Tercapai</span>
                         </div>
                         <div class="w-full bg-slate-100 rounded-full h-3">
                             <div class="bg-emerald-400 h-3 rounded-full" style="width: 60%"></div>
                         </div>
                         <p class="text-xs text-slate-400 mt-2 text-right">Target: Rp 20.000.000</p>
                     </div>
                 </div>
            </x-card>
        </div>
        
        <!-- Top Expense Category & AI Insights Quick View -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <x-card title="Top Expense Category" class="rounded-3xl shadow-sm border-0 bg-white">
                 <div class="flex items-center gap-4 mt-2">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex justify-center items-center">
                        <i class="fa-solid fa-car text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Transportasi</h4>
                        <p class="text-sm text-slate-500">Rp 5.000.000</p>
                    </div>
                 </div>
            </x-card>
            <x-card title="AI Insights" class="rounded-3xl shadow-sm border-0 bg-white lg:col-span-2" padding="false">
                 <div class="p-6">
                     <div class="flex gap-4 p-5 bg-emerald-50/70 border border-emerald-100 text-emerald-900 rounded-3xl text-sm leading-relaxed">
                         <div class="text-2xl text-emerald-500"><i class="fa-solid fa-sparkles"></i></div>
                         <div>
                            <h4 class="font-bold mb-1 text-emerald-700">Insight Mingguan</h4>
                            <p>Pengeluaran transportasi Anda naik 20% bulan ini. N8n AI merekomendasikan untuk beralih ke transportasi umum sedikitnya 2 hari seminggu untuk mempertahankan target Budget Anda.</p>
                         </div>
                     </div>
                 </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
