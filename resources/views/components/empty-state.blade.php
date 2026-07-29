@props([
    'title' => 'Tidak Ada Data',
    'description' => 'Belum ada data yang tersedia saat ini.',
    'icon' => 'folder-open'
])

<div class="py-12 px-4 text-center">
    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mx-auto mb-4 border border-indigo-100 shadow-xs">
        <i class="fa-solid fa-{{ $icon }}"></i>
    </div>
    <h4 class="text-base font-bold text-slate-800 tracking-tight">{{ $title }}</h4>
    <p class="text-xs text-slate-400 max-w-sm mx-auto mt-1">{{ $description }}</p>

    @if (isset($action))
        <div class="mt-5">
            {{ $action }}
        </div>
    @endif
</div>
