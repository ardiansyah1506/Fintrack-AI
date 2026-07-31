<x-app-layout title="Telegram Config - Control Center">
    <x-slot name="header">Telegram / AI Setup</x-slot>
    <div class="space-y-6 text-slate-800 font-sans">
        <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-slate-100 text-center">
            <div class="inline-flex w-24 h-24 bg-gradient-to-br from-indigo-50 to-indigo-100 text-indigo-600 rounded-3xl shadow-inner items-center justify-center mb-6">
                <i class="fa-brands fa-telegram text-5xl"></i>
            </div>
            <h2 class="font-bold text-3xl text-slate-800 mb-3 tracking-tight">Telegram Bot Terhubung!</h2>
            <p class="text-slate-500 max-w-lg mx-auto text-sm leading-relaxed mb-10">
                Data akan selalu disinkronisasi melalui webhook N8n setiap kali ada input pesan chat melalui telegram assistant secara real-time.
            </p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto mt-4">
                <div class="bg-slate-50/50 rounded-2xl p-5 text-center border border-slate-100">
                    <p class="text-[10px] uppercase font-bold text-slate-400 mb-2 tracking-widest">Bot Status</p>
                    <p class="font-bold text-emerald-600 flex items-center justify-center gap-1.5"><i class="fa-solid fa-circle text-[8px] animate-pulse"></i> ONLINE</p>
                </div>
                <div class="bg-slate-50/50 rounded-2xl p-5 text-center border border-slate-100">
                    <p class="text-[10px] uppercase font-bold text-slate-400 mb-2 tracking-widest">Last Sync</p>
                    <p class="font-bold text-slate-700">Baru Saja</p>
                </div>
                <div class="bg-slate-50/50 rounded-2xl p-5 text-center border border-slate-100">
                    <p class="text-[10px] uppercase font-bold text-slate-400 mb-2 tracking-widest">Webhook Status</p>
                    <p class="font-bold text-indigo-600">Active</p>
                </div>
                <div class="bg-slate-50/50 rounded-2xl p-5 text-center border border-slate-100">
                    <p class="text-[10px] uppercase font-bold text-slate-400 mb-2 tracking-widest">Workflow Engine</p>
                    <p class="font-bold text-amber-500">Listening</p>
                </div>
            </div>
            
            <div class="mt-12 max-w-3xl mx-auto text-left bg-slate-900 border border-slate-800 text-slate-200 p-8 rounded-3xl shadow-xl">
                <div class="flex items-center gap-3 mb-4 border-b border-slate-800 pb-4">
                    <i class="fa-solid fa-terminal text-emerald-500"></i>
                    <h4 class="font-bold text-sm text-slate-300 tracking-wide uppercase">Live Hook Snapshot Log</h4>
                </div>
                <div class="font-mono text-[13px] text-emerald-400 bg-black/40 shadow-inner p-5 rounded-2xl overflow-x-auto leading-relaxed h-32">
<pre>{
  "event": "message_received",
  "intent": "create_transaction", 
  "amount": 25000, 
  "category": "Makanan", 
  "description": "Bakso"
}</pre>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
