@props([
    'headers' => []
])

<div class="w-full overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-700">
        @if(!empty($headers))
            <thead class="bg-slate-50 text-[11px] font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-3.5">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-slate-100">
            {{ $slot }}
        </tbody>
    </table>
</div>
