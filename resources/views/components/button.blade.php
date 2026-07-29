@props([
    'variant' => 'primary', // primary, secondary, danger, success, ghost
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'icon' => null,
    'href' => null,
])

@php
    $variants = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm shadow-indigo-500/20 border border-indigo-600 hover:border-indigo-700',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-slate-200 dark:border-slate-600',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white shadow-sm shadow-rose-500/20 border border-rose-600 hover:border-rose-700',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm shadow-emerald-500/20 border border-emerald-600 hover:border-emerald-700',
        'ghost' => 'bg-transparent hover:bg-slate-100 text-slate-600 dark:text-slate-300 dark:hover:bg-slate-800 border border-transparent',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs rounded-lg gap-1.5',
        'md' => 'px-4 py-2 text-sm rounded-xl gap-2',
        'lg' => 'px-5 py-2.5 text-base rounded-xl gap-2.5',
    ];

    $classes = 'inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 active:scale-95 disabled:opacity-50 disabled:pointer-events-none '
        . ($variants[$variant] ?? $variants['primary']) . ' '
        . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="fa-solid fa-{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="fa-solid fa-{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </button>
@endif
