@props([
    'type' => 'success', // success, error, info, warning
    'dismissible' => true,
    'message' => null,
])

@php
    $types = [
        'success' => [
            'bg' => 'bg-emerald-50 dark:bg-emerald-950/40',
            'border' => 'border-emerald-200 dark:border-emerald-800',
            'text' => 'text-emerald-800 dark:text-emerald-200',
            'icon' => 'circle-check text-emerald-500',
        ],
        'error' => [
            'bg' => 'bg-rose-50 dark:bg-rose-950/40',
            'border' => 'border-rose-200 dark:border-rose-800',
            'text' => 'text-rose-800 dark:text-rose-200',
            'icon' => 'circle-xmark text-rose-500',
        ],
        'info' => [
            'bg' => 'bg-sky-50 dark:bg-sky-950/40',
            'border' => 'border-sky-200 dark:border-sky-800',
            'text' => 'text-sky-800 dark:text-sky-200',
            'icon' => 'circle-info text-sky-500',
        ],
        'warning' => [
            'bg' => 'bg-amber-50 dark:bg-amber-950/40',
            'border' => 'border-amber-200 dark:border-amber-800',
            'text' => 'text-amber-800 dark:text-amber-200',
            'icon' => 'triangle-exclamation text-amber-500',
        ],
    ];

    $current = $types[$type] ?? $types['info'];
@endphp

<div
    x-data="{ open: true }"
    x-show="open"
    x-transition
    class="p-4 rounded-2xl border {{ $current['bg'] }} {{ $current['border'] }} {{ $current['text'] }} flex items-start gap-3 shadow-xs mb-4"
>
    <div class="mt-0.5 text-lg">
        <i class="fa-solid fa-{{ $current['icon'] }}"></i>
    </div>
    <div class="flex-1 text-sm font-medium">
        {{ $message ?? $slot }}
    </div>
    @if($dismissible)
        <button x-on:click="open = false" type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition">
            <i class="fa-solid fa-xmark text-base"></i>
        </button>
    @endif
</div>
