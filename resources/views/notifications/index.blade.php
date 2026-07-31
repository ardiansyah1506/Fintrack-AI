<x-app-layout title="Notifications - Control Center">
    <x-slot name="header">Notification Center</x-slot>
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden font-sans">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h2 class="font-bold text-xl text-slate-800">Daftar Notifikasi</h2>
            <button class="text-emerald-600 text-sm font-semibold hover:underline">Tandai semua dibaca</button>
        </div>
        <div class="divide-y divide-slate-100 text-slate-800">
            @forelse($notifications as $notif)
            <div class="p-6 flex items-start gap-4 {{ $notif->read_at ? 'bg-white opacity-70' : 'bg-emerald-50/20' }} hover:bg-slate-50 transition">
                <div class="w-10 h-10 rounded-full flex justify-center items-center shrink-0 shadow-sm
                    {{ $notif->type == 'warning' ? 'bg-amber-100 text-amber-600' : ($notif->type == 'success' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600') }}">
                    <i class="fa-solid {{ $notif->type == 'warning' ? 'fa-triangle-exclamation' : ($notif->type == 'success' ? 'fa-check' : 'fa-bell') }}"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm mb-1 text-slate-800">{{ $notif->title }}</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ $notif->message }}</p>
                    <p class="text-[10px] font-semibold text-slate-400 mt-2 tracking-wide">{{ date('d M Y H:i', strtotime($notif->created_at)) }}</p>
                </div>
            </div>
            @empty
            <div class="p-10 text-center text-slate-400 text-sm">Tidak ada notifikasi aktif.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
