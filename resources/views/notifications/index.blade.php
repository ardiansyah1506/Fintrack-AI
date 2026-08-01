<x-app-layout title="Notifications - Control Center">
    <x-slot name="header">Notifications</x-slot>
    
    <div x-data="{ showModal: false, editMode: false, currentId: null, form: { title: '', message: '', type: 'info', is_read: 0 } }" class="space-y-6 text-slate-800 font-sans relative">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Manajemen Notifikasi</h2>
                <p class="text-xs text-slate-400 mt-1">Kelola pemberitahuan internal sistem.</p>
            </div>
            <button @click="showModal = true; editMode = false; form = { title: '', message: '', type: 'info', is_read: 0 }" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Notifikasi
            </button>
        </div>
        
        <form method='GET' action='{{ request()->url() }}' class='flex gap-2 w-full max-w-sm mt-4 md:mt-0'>
            <input type='text' name='search' value='{{ request()->search }}' placeholder='Cari notifikasi...' class='w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50'>
            <button type='submit' class='bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition'><i class='fa-solid fa-search'></i></button>
            @if(request()->search)
                <a href='{{ request()->url() }}' class='bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-xl text-sm font-semibold transition'><i class='fa-solid fa-xmark'></i></a>
            @endif
        </form>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Pesan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80 text-slate-700">
                    @forelse($notifications as $notif)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-medium uppercase text-xs">{{ $notif->type }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $notif->name }}</div>
                            <div class="text-xs text-slate-500 truncate max-w-sm">{{ $notif->message }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg border {{ $notif->is_read ? 'bg-slate-100 text-slate-500 border-slate-200' : 'bg-emerald-50 text-emerald-600 border-emerald-200' }}">
                                {{ $notif->is_read ? 'DIBACA' : 'BARU' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="showModal = true; editMode = true; currentId = {{ $notif->id }}; form = { title: '{{ addslashes($notif->name) }}', message: '{{ addslashes($notif->message) }}', type: '{{ $notif->type }}', is_read: '{{ $notif->is_read }}' }" class="text-indigo-600 hover:text-indigo-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('notifications', $notif->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus notifikasi ini?')" class="text-rose-600 hover:text-rose-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada notifikasi tersimpan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class='mt-4'>
            {{ $notifications->appends(['search' => request('search')])->links() }}
        </div>

        <!-- Alpine Modal -->
        <div x-show="showModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showModal = false"></div>
            <div class="bg-white rounded-3xl p-6 w-full max-w-lg z-10 shadow-2xl relative" x-transition>
                <button @click="showModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                <h3 class="text-lg font-bold text-slate-800 mb-4" x-text="editMode ? 'Edit Notifikasi' : 'Buat Notifikasi Baru'"></h3>
                
                <form :action="editMode ? '{{ url('notifications') }}/' + currentId : '{{ route('notifications.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    <input type="hidden" name="user_id" value="1">
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama / Judul</label>
                        <input type="text" name="name" x-model="form.title" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pesan</label>
                        <textarea name="message" x-model="form.message" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50" required rows="3"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tipe</label>
                            <select name="type" x-model="form.type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                                <option value="info">Info</option>
                                <option value="warning">Warning</option>
                                <option value="success">Success</option>
                                <option value="error">Error</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                            <select name="is_read" x-model="form.is_read" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                                <option value="0">Baru (Belum Dibaca)</option>
                                <option value="1">Sudah Dibaca</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-xl font-semibold text-slate-500 hover:bg-slate-100 transition">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>