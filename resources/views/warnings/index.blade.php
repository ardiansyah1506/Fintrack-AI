<x-app-layout title="AI Warnings - AI Center">
    <x-slot name="header">AI Warnings</x-slot>
    <div x-data="{ showModal: false, editMode: false, currentId: null, form: {'title': '', 'description': '', 'severity': '', 'resolved': ''} }" class="space-y-6 text-slate-800 font-sans relative">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Manajemen AI Warnings</h2>
            </div>
            <button @click="showModal = true; editMode = false; form = {'title': '', 'description': '', 'severity': '', 'resolved': ''}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
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
                        <th class='px-6 py-4'>title</th><th class='px-6 py-4'>description</th><th class='px-6 py-4'>severity</th><th class='px-6 py-4'>resolved</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($warnings as $item)
                    <tr class="hover:bg-slate-50">
                        <td class='px-6 py-4 truncate max-w-xs'>{{ $item->title }}</td><td class='px-6 py-4 truncate max-w-xs'>{{ $item->description }}</td><td class='px-6 py-4 truncate max-w-xs'>{{ $item->severity }}</td><td class='px-6 py-4 truncate max-w-xs'>{{ $item->resolved }}</td>
                        <td class="px-6 py-4 text-right">
                            <button @click="showModal = true; editMode = true; currentId = {{ $item->id }}; form = {'title': '{{ addslashes($item->title ?? "") }}', 'description': '{{ addslashes($item->description ?? "") }}', 'severity': '{{ addslashes($item->severity ?? "") }}', 'resolved': '{{ addslashes($item->resolved ?? "") }}'}" class="text-indigo-600 hover:text-indigo-800 mx-2 text-xs"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('warnings', $item->id) }}" method="POST" class="inline">
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
        <div class='mt-4'>{{ $warnings->appends(['search' => request('search')])->links() }}</div>
        
        <!-- Modal -->
        <div x-show="showModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showModal = false"></div>
            <div class="bg-white rounded-3xl p-6 w-full max-w-lg z-10 shadow-2xl relative" x-transition>
                <button @click="showModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                <h3 class="text-lg font-bold text-slate-800 mb-4" x-text="editMode ? 'Edit Data' : 'Tambah Data'"></h3>
                <form :action="editMode ? '{{ url('warnings') }}/' + currentId : '{{ url('warnings') }}'" method="POST" class="space-y-4 max-h-[70vh] overflow-y-auto">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    
                    <div>
                        <label class='block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2'>title</label>
                        <input type='text' name='title' x-model='form.title' class='w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500' required>
                    </div>
                    <div>
                        <label class='block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2'>description</label>
                        <input type='text' name='description' x-model='form.description' class='w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500' required>
                    </div>
                    <div>
                        <label class='block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2'>severity</label>
                        <input type='text' name='severity' x-model='form.severity' class='w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500' required>
                    </div>
                    <div>
                        <label class='block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2'>resolved</label>
                        <input type='text' name='resolved' x-model='form.resolved' class='w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500' required>
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