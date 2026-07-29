@props(['title' => null])

<x-layouts.app :title="$title" {{ $attributes }}>
    @if(isset($header))
        <x-slot name="header">
            {{ $header }}
        </x-slot>
    @endif

    @if(isset($breadcrumb))
        <x-slot name="breadcrumb">
            {{ $breadcrumb }}
        </x-slot>
    @endif

    {{ $slot }}
</x-layouts.app>
