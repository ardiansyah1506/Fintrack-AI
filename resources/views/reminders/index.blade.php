<x-app-layout title="Reminders - Control Center">
    <x-slot name="header">Reminders</x-slot>
    
    <div x-data="{ showModal: false, editMode: false, currentId: null, form: { title: '', due_date: '', due_time: '', priority: 'normal', status: 'pending' } }" class="space-y-6 text-slate-800 font-sans relative">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Daftar Pengingat N8n</h2>
                <p class="text-xs text-slate-400 mt-1">Data sinkronisasi dengan Telegram Bot.</p>
            </div>
            <button @click="showModal = true; editMode = false; form = { title: '', due_date: '', due_time: '', priority: 'normal', status: 'pending' }" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Reminder
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Status & Prioritas</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80 text-slate-700">
                    @forelse($reminders as $reminder)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-medium">{{ $reminder->title }}</td>
                        <td class="px-6 py-4">{{ $reminder->due_date }} ({{ $reminder->due_time }})</td>
                        <td class="px-6 py-4 flex gap-2">
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg border {{ $reminder->status == 'done' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                {{ strtoupper($reminder->status) }}
                            </span>
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg border bg-rose-50 text-rose-600 border-rose-200">
                                {{ strtoupper($reminder->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="showModal = true; editMode = true; currentId = {{ $reminder->id }}; form = { title: '{{ addslashes($reminder->title) }}', due_date: '{{ $reminder->due_date }}', due_time: '{{ $reminder->due_time }}', priority: '{{ $reminder->priority }}', status: '{{ $reminder->status }}' }" class="text-indigo-600 hover:text-indigo-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ route('reminders.destroy', $reminder->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus reminder ini?')" class="text-rose-600 hover:text-rose-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada reminder.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Alpine Modal -->
        <div x-show="showModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showModal = false"></div>
            <div class="bg-white rounded-3xl p-6 w-full max-w-lg z-10 shadow-2xl relative" x-transition>
                <button @click="showModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                <h3 class="text-lg font-bold text-slate-800 mb-4" x-text="editMode ? 'Edit Reminder' : 'Tambah Reminder Baru'"></h3>
                
                <form :action="editMode ? '{{ url('reminders') }}/' + currentId : '{{ route('reminders.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Judul</label>
                        <input type="text" name="title" x-model="form.title" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tanggal</label>
                            <input type="date" name="due_date" x-model="form.due_date" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Jam</label>
                            <input type="time" name="due_time" x-model="form.due_time" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Prioritas</label>
                            <select name="priority" x-model="form.priority" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                                <option value="low">Low</option>
                                <option value="normal">Normal</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                            <select name="status" x-model="form.status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                                <option value="pending">Pending</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-xl font-semibold text-slate-500 hover:bg-slate-100 transition">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
