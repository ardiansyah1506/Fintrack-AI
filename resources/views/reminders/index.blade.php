<x-app-layout title="Reminders - Control Center">
    <x-slot name="header">Reminders</x-slot>
    <div class="space-y-6 text-slate-800 font-sans">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Daftar Pengingat N8n</h2>
                <p class="text-xs text-slate-400 mt-1">Data dikontrol dan dijalankan oleh Telegram Bot.</p>
            </div>
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Reminder
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80 text-slate-700">
                    @forelse($reminders as $reminder)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-medium">{{ $reminder->title }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg border 
                                {{ $reminder->status == 'done' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                {{ strtoupper($reminder->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right opacity-50 hover:opacity-100">
                            <a href="#" class="text-indigo-600 text-xs font-semibold">Tinjau</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-slate-400">Belum ada reminder.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
