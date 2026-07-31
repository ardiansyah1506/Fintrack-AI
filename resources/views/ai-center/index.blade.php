<x-app-layout title="AI Center - FinTrack AI OS">
    <x-slot name="header">AI Control Center</x-slot>
    <x-slot name="breadcrumb">Home / Dashboards / AI Center</x-slot>

    <div class="space-y-6 text-slate-800 font-sans">
        <!-- AI System Status -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
             <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 flex flex-col justify-center text-center">
                 <div class="mx-auto w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                     <i class="fa-solid fa-server"></i>
                 </div>
                 <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">N8n Webhook</p>
                 <h3 class="text-lg font-bold text-emerald-500 mt-1">Active</h3>
             </div>
             <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 flex flex-col justify-center text-center">
                 <div class="mx-auto w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-3">
                     <i class="fa-solid fa-brain"></i>
                 </div>
                 <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Gemini Engine</p>
                 <h3 class="text-lg font-bold text-blue-500 mt-1">Online</h3>
             </div>
             <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 flex flex-col justify-center text-center">
                 <div class="mx-auto w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-3">
                     <i class="fa-solid fa-memory"></i>
                 </div>
                 <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">AI Memories</p>
                 <h3 class="text-lg font-bold text-slate-800 mt-1">14 Keys</h3>
             </div>
             <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 flex flex-col justify-center text-center">
                 <div class="mx-auto w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mb-3">
                     <i class="fa-solid fa-triangle-exclamation"></i>
                 </div>
                 <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Warnings</p>
                 <h3 class="text-lg font-bold text-rose-500 mt-1">0 Issue</h3>
             </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Latest Predictions -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 h-full">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-slate-700 flex items-center gap-2"><i class="fa-solid fa-chart-line text-emerald-500"></i> AI Predictions</h3>
                    <button class="text-xs font-bold text-slate-400 hover:text-emerald-500">View All</button>
                </div>
                <div class="space-y-4">
                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-piggy-bank"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Target Tabungan (Prob: 92%)</h4>
                            <p class="text-xs text-slate-500 mt-1">Berdasarkan siklus income 3 bulan, target liburan Jepang diprediksi akan selesai lebih awal (Des 2026).</p>
                        </div>
                    </div>
                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-fire"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">Budget Warning (Prob: 75%)</h4>
                            <p class="text-xs text-slate-500 mt-1">Anggaran Makanan berpotensi overbudget sebesar Rp200.000 mendekati akhir bulan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vector Memory Store -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 h-full">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-slate-700 flex items-center gap-2"><i class="fa-solid fa-database text-indigo-500"></i> AI Memory Scope</h3>
                    <button class="text-xs font-bold text-slate-400 hover:text-indigo-500">Manage</button>
                </div>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold border border-indigo-100">Kategori: Makan Harian</span>
                    <span class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold border border-indigo-100">Jam Kerja: 09:00 - 17:00</span>
                    <span class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold border border-indigo-100">Tagihan Netlflix: Rp185k</span>
                    <span class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold border border-indigo-100">Limit Harian: Rp100k</span>
                    <span class="px-3 py-1.5 bg-slate-50 text-slate-400 rounded-lg text-xs font-bold border border-slate-100 border-dashed">+ 10 More Nodes</span>
                </div>
                <p class="text-xs text-slate-400 mt-4 leading-relaxed">System Memory secara pasif mempelajari pola keuangan melalui interaksi chat N8n dan menyimpannya di Laravel sebagai Vector Knowledge.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Logs -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl lg:col-span-2 overflow-hidden text-emerald-400 font-mono text-sm relative">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-slate-300 font-sans tracking-wide">Live Transaction Logs (Intent)</h3>
                    <span class="flex h-2.5 w-2.5 relative">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                </div>
                <div class="space-y-2 opacity-80 h-[200px] overflow-y-auto custom-scrollbar">
                    <p>[2026-07-31 16:40:22] <span class="text-slate-400">INFO     :</span> POST /api/bot/execute - Processing intent 'create_transaction'...</p>
                    <p>[2026-07-31 16:40:22] <span class="text-blue-400">DISPATCH :</span> Resolved CreateTransactionIntent -> App\\Intents\\Transactions\\CreateTransactionIntent</p>
                    <p>[2026-07-31 16:40:23] <span class="text-emerald-400">SUCCESS  :</span> Transaction ID#829 inserted via Telegram (Amount: 35000, Cat: Makan)</p>
                    <p>[2026-07-31 16:40:24] <span class="text-slate-400">INFO     :</span> Response 200 OK returned to N8n Webhook.</p>
                    <p class="mt-4">[2026-08-01 07:15:00] <span class="text-orange-400">WARN     :</span> Daily prediction task running... 409ms.</p>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-slate-900 to-transparent"></div>
            </div>

            <!-- Prompt Manager Quick Access -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-700 mb-4 flex items-center gap-2"><i class="fa-solid fa-code text-slate-400"></i> Active Prompts</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 border border-slate-100 rounded-xl bg-slate-50">
                        <div>
                            <p class="text-xs font-bold text-slate-700">Intent Parser / NLU</p>
                            <p class="text-[10px] text-slate-400">v1.2 (Active)</p>
                        </div>
                        <button class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 flex justify-center items-center"><i class="fa-solid fa-pen"></i></button>
                    </div>
                    <div class="flex justify-between items-center p-3 border border-slate-100 rounded-xl bg-slate-50">
                        <div>
                            <p class="text-xs font-bold text-slate-700">Predictive Model</p>
                            <p class="text-[10px] text-slate-400">v1.0 (Active)</p>
                        </div>
                        <button class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 flex justify-center items-center"><i class="fa-solid fa-pen"></i></button>
                    </div>
                    <div class="flex justify-between items-center p-3 border border-slate-100 rounded-xl bg-slate-50">
                        <div>
                            <p class="text-xs font-bold text-slate-700">Smart Warning Generator</p>
                            <p class="text-[10px] text-slate-400">v2.1 (Active)</p>
                        </div>
                        <button class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-emerald-500 flex justify-center items-center"><i class="fa-solid fa-pen"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
