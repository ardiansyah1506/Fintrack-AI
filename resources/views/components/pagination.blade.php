@props([
    'paginator'
])

@if ($paginator->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between gap-4">
        <div class="text-xs text-slate-500">
            Menampilkan <span class="font-semibold text-slate-700">{{ $paginator->firstItem() }}</span> sampai <span class="font-semibold text-slate-700">{{ $paginator->lastItem() }}</span> dari <span class="font-semibold text-slate-700">{{ $paginator->total() }}</span> hasil
        </div>

        <div class="flex items-center gap-1.5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
@endif
