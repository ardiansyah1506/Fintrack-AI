<x-app-layout title="Predictions - AI Center">
    <x-slot name="header">Predictions</x-slot>
    <div x-data="{ showModal: false, editMode: false }" class="space-y-6 text-slate-800 font-sans relative">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">AI Predictions</h2>
            </div>
            
        </div>
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider"><tr><th class='px-6 py-4'>title</th>
<th class='px-6 py-4'>probability</th>
<th class='px-6 py-4'>description</th>
</tr></thead>
                <tbody class="divide-y divide-slate-100/80 text-slate-700">
                    @forelse($data as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class='px-6 py-4'>{{ $item->title }}</td>
<td class='px-6 py-4'>{{ $item->probability }}</td>
<td class='px-6 py-4'>{{ $item->description }}</td>

                        
                    </tr>
                    @empty
                    <tr><td colspan='10' class='px-6 py-8 text-center text-slate-400'>Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>
</x-app-layout>