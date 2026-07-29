@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'icon' => null,
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
            {{ $label }} {!! $required ? '<span class="text-rose-500">*</span>' : '' !!}
        </label>
    @endif

    <div class="relative rounded-xl shadow-2xs">
        @if ($icon)
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <i class="fa-solid fa-{{ $icon }} text-xs"></i>
            </div>
        @endif

        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 ' . ($icon ? 'pl-9' : 'px-3.5') . ' py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all placeholder:text-slate-400']) }}
        />
    </div>

    @error($name)
        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
    @enderror
</div>
