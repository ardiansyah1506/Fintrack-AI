<x-app-layout title="Telegram Center - FinTrack AI OS">
    <x-slot name="header">Telegram System Center</x-slot>
    <x-slot name="breadcrumb">Home / Dashboards / Telegram Center</x-slot>

    <div class="space-y-6 text-slate-800 font-sans">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
             <div class="col-span-1 md:col-span-2 lg:col-span-4 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-6 text-white shadow-lg flex items-center justify-between">
                 <div>
                    <h2 class="text-2xl font-bold flex items-center gap-3"><i class="fa-brands fa-telegram"></i> Telegram Bot Link</h2>
                    <p class="text-blue-100 mt-2 text-sm max-w-lg leading-relaxed">Interaksi NLP langsung dengan FinTrack AI. Seluruh pesan dikirim ke N8N Webhook dan direlasikan dengan Laravel Database untuk menyimpan data operasional Anda.</p>
                 </div>
                 <button class="bg-white text-blue-600 px-6 py-3 rounded-xl font-bold hover:bg-slate-50 shadow-sm transition hidden md:block">
                     Test Connection
                 </button>
             </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Node Connectivity -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Webhook Status</p>
                <div class="flex items-center justify-between">
                    <h3 class="text-3xl font-bold text-slate-800">200 <span class="text-sm font-normal text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-lg">OK</span></h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Latency avg</p>
                <div class="flex items-center justify-between">
                    <h3 class="text-3xl font-bold text-slate-800">42<span class="text-lg text-slate-400 font-medium ml-1">ms</span></h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Error Rate</p>
                <div class="flex items-center justify-between">
                    <h3 class="text-3xl font-bold text-slate-800">0.0<span class="text-lg text-slate-400 font-medium ml-1">%</span></h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Queue / Retry</p>
                <div class="flex items-center justify-between">
                    <h3 class="text-3xl font-bold text-slate-800">0 <span class="text-lg text-slate-400 font-medium ml-1">/ 3</span></h3>
                </div>
            </div>
        </div>

        <!-- Automation & Scheduler Status -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-700 mb-6 flex items-center gap-2"><i class="fa-solid fa-code-branch text-slate-400"></i> N8N Main Workflows</h3>
                <div class="space-y-4 text-sm font-medium">
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <div class="flex gap-3 items-center">
                            <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span>
                            <span class="text-slate-700">Telegram NLP Parser Route</span>
                        </div>
                        <span class="text-emerald-500">Running</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <div class="flex gap-3 items-center">
                            <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span>
                            <span class="text-slate-700">Daily Report Broadcast (Cron)</span>
                        </div>
                        <span class="text-emerald-500">Idle / Next: 19:00</span>
                    </div>
                </div>
            </div>

            <!-- Chat Metrics -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-700 mb-6 flex items-center gap-2"><i class="fa-solid fa-message text-slate-400"></i> Telegram Chat Interactions</h3>
                <div class="flex gap-6 mb-6">
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Last Sync</p>
                        <p class="font-bold text-slate-800">Just now</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Daily Requests</p>
                        <p class="font-bold text-slate-800">42 msgs</p>
                    </div>
                </div>
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                    <p class="text-xs text-slate-400 mb-2">Terakhir Diterima:</p>
                    <p class="text-sm text-slate-700 italic font-medium">"Tolong catat pengeluaran makan malam di KFC hari ini sebesar 55 ribu ya"</p>
                    <p class="text-[10px] text-emerald-500 font-bold mt-3 uppercase">Parser Output: CreateTransactionIntent</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
