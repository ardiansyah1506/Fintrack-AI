@props([
    'variant' => 'info', // info, success, danger, warning, neutral
    'size' => 'md',
    'icon' => null,
])

@php
    $variants = [
        'info' => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/50 dark:text-indigo-300 dark:border-indigo-800',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800',
        'danger' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800',
        'neutral' => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-xs',
        'lg' => 'px-3 py-1.5 text-sm',
    ];

    $classes = 'inline-flex items-center gap-1.5 font-medium rounded-lg border shadow-2xs '
        . ($variants[$variant] ?? $variants['neutral']) . ' '
        . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class="fa-solid fa-{{ $icon }} text-[0.85em]"></i>
    @endif
    {{ $slot }}
</span>
