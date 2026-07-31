<x-app-layout title="Memories - AI Center">
    <x-slot name="header">Memories</x-slot>
    <div x-data="{ showModal: false, editMode: false }" class="space-y-6 text-slate-800 font-sans relative">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">AI Memories</h2>
            </div>
            <button @click="showModal = true; editMode = false;" class='bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition'><i class='fa-solid fa-plus mr-2'></i> Tambah</button>
        </div>
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider"><tr><th class='px-6 py-4'>key</th>
<th class='px-6 py-4'>value</th>
<th class='px-6 py-4'>context</th>
<th class='px-6 py-4 text-right'>Aksi</th></tr></thead>
                <tbody class="divide-y divide-slate-100/80 text-slate-700">
                    @forelse($data as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class='px-6 py-4'>{{ $item->key }}</td>
<td class='px-6 py-4'>{{ $item->value }}</td>
<td class='px-6 py-4'>{{ $item->context }}</td>

                        <td class='px-6 py-4 text-right'>
            <form action="{{ url('memories', $item->id) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Hapus data ini?')" class="text-rose-600 hover:text-rose-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-trash"></i></button>
            </form>
        </td>
                    </tr>
                    @empty
                    <tr><td colspan='10' class='px-6 py-8 text-center text-slate-400'>Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div x-show='showModal' style='display:none;' class='fixed inset-0 z-50 flex items-center justify-center'>
            <div class='fixed inset-0 bg-slate-900/40 backdrop-blur-sm' @click='showModal = false'></div>
            <div class='bg-white rounded-3xl p-6 w-full max-w-lg z-10 shadow-2xl relative' x-transition>
                <form action="{{ route('memories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div><label class='block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2'>Field</label>
                    <input type='text' name='key' class='w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none' required>
                    </div>
                    <div class='pt-4 flex justify-end gap-3'>
                        <button type='submit' class='px-5 py-2.5 rounded-xl font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition'>Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>