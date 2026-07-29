<x-app-layout title="Pengaturan - FinTrack AI">
    <x-slot name="header">Pengaturan Aplikasi</x-slot>
    <x-slot name="breadcrumb">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span>Pengaturan</span>
    </x-slot>

    <div class="max-w-4xl space-y-6">
        <!-- System Status Card -->
        <x-card title="Status Integrasi & Konfigurasi System" subtitle="Informasi backend Laravel dan REST API n8n">
            <div class="space-y-4 text-sm">
                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800">Database MySQL</h4>
                            <p class="text-xs text-slate-400">Database `fintrack_ai` terhubung & aktif (Single Source of Truth)</p>
                        </div>
                    </div>
                    <x-badge variant="success" icon="check">Connected</x-badge>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-robot"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800">Telegram Bot & n8n Engine</h4>
                            <p class="text-xs text-slate-400">REST API Endpoint `POST /api/bot/execute` siap menerima payload intent</p>
                        </div>
                    </div>
                    <x-badge variant="info" icon="paper-plane">Ready</x-badge>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-cube"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-800">Framework Stack</h4>
                            <p class="text-xs text-slate-400">Laravel 12 (MVC + Service Layer) tanpa build tool NPM (CDN Mode)</p>
                        </div>
                    </div>
                    <x-badge variant="neutral">Single User Mode</x-badge>
                </div>
            </div>
        </x-card>
    </div>
</x-app-layout>
