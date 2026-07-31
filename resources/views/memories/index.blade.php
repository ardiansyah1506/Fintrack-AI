<x-app-layout title="AI Memories - AI Center">
    <x-slot name="header">AI Memories</x-slot>
    <div x-data="{ showModal: false, editMode: false, currentId: null, form: {'key': '', 'value': '', 'type': '', 'active': ''} }" class="space-y-6 text-slate-800 font-sans relative">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Manajemen AI Memories</h2>
            </div>
            <button @click="showModal = true; editMode = false; form = {'key': '', 'value': '', 'type': '', 'active': ''}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Data
            </button>
        </div>
        <form method='GET' action='{{ request()->url() }}' class='flex gap-2 w-full max-w-sm'>
            <input type='text' name='search' value='{{ request()->search }}' placeholder='Pencarian...' class='w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50'>
            <button type='submit' class='bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-semibold'><i class='fa-solid fa-search'></i></button>
            @if(request()->search) <a href='{{ request()->url() }}' class='bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-xl text-sm font-semibold'><i class='fa-solid fa-xmark'></i></a> @endif
        </form>
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class='px-6 py-4'>key</th><th class='px-6 py-4'>value</th><th class='px-6 py-4'>type</th><th class='px-6 py-4'>active</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($memories as $item)
                    <tr class="hover:bg-slate-50">
                        <td class='px-6 py-4 truncate max-w-xs'>{{ $item->key }}</td><td class='px-6 py-4 truncate max-w-xs'>{{ $item->value }}</td><td class='px-6 py-4 truncate max-w-xs'>{{ $item->type }}</td><td class='px-6 py-4 truncate max-w-xs'>{{ $item->active }}</td>
                        <td class="px-6 py-4 text-right">
                            <button @click="showModal = true; editMode = true; currentId = {{ $item->id }}; form = {'key': '{{ addslashes($item->key ?? "") }}', 'value': '{{ addslashes($item->value ?? "") }}', 'type': '{{ addslashes($item->type ?? "") }}', 'active': '{{ addslashes($item->active ?? "") }}'}" class="text-indigo-600 hover:text-indigo-800 mx-2 text-xs"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('memories', $item->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus data?')" class="text-rose-600 hover:text-rose-800 mx-2 text-xs"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada data tercatat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class='mt-4'>{{ $memories->appends(['search' => request('search')])->links() }}</div>
        
        <!-- Modal -->
        <div x-show="showModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showModal = false"></div>
            <div class="bg-white rounded-3xl p-6 w-full max-w-lg z-10 shadow-2xl relative" x-transition>
                <button @click="showModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                <h3 class="text-lg font-bold text-slate-800 mb-4" x-text="editMode ? 'Edit Data' : 'Tambah Data'"></h3>
                <form :action="editMode ? '{{ url('memories') }}/' + currentId : '{{ url('memories') }}'" method="POST" class="space-y-4 max-h-[70vh] overflow-y-auto">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    
                    <div>
                        <label class='block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2'>key</label>
                        <input type='text' name='key' x-model='form.key' class='w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500' required>
                    </div>
                    <div>
                        <label class='block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2'>value</label>
                        <input type='text' name='value' x-model='form.value' class='w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500' required>
                    </div>
                    <div>
                        <label class='block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2'>type</label>
                        <input type='text' name='type' x-model='form.type' class='w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500' required>
                    </div>
                    <div>
                        <label class='block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2'>active</label>
                        <input type='text' name='active' x-model='form.active' class='w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500' required>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-100 sticky bottom-0 bg-white pb-2">
                        <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-xl font-semibold text-slate-500 hover:bg-slate-100">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl font-semibold text-white bg-indigo-600 hover:bg-indigo-700">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>