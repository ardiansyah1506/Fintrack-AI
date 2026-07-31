<x-app-layout title="AiLogs - AI Center">
    <x-slot name="header">AiLogs</x-slot>
    <div x-data="{ showModal: false, editMode: false }" class="space-y-6 text-slate-800 font-sans relative">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">AI AiLogs</h2>
            </div>
            
        </div>
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider"><tr><th class='px-6 py-4'>intent</th>
<th class='px-6 py-4'>latency_ms</th>
<th class='px-6 py-4'>status</th>
<th class='px-6 py-4'>response</th>
</tr></thead>
                <tbody class="divide-y divide-slate-100/80 text-slate-700">
                    @forelse($data as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class='px-6 py-4'>{{ $item->intent }}</td>
<td class='px-6 py-4'>{{ $item->latency_ms }}</td>
<td class='px-6 py-4'>{{ $item->status }}</td>
<td class='px-6 py-4'>{{ $item->response }}</td>

                        
                    </tr>
                    @empty
                    <tr><td colspan='10' class='px-6 py-8 text-center text-slate-400'>Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>
</x-app-layout>