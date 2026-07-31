<x-app-layout title="Saving Goals - Control Center">
    <x-slot name="header">Saving Goals</x-slot>
    
    <div x-data="{ showModal: false, editMode: false, currentId: null, form: { title: '', target_amount: '', current_amount: '0', deadline: '', icon: 'fa-bullseye', status: 'active' } }" class="space-y-6 text-slate-800 font-sans relative">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Target Tabungan</h2>
                <p class="text-xs text-slate-400 mt-1">Lacak pencapaian resolusi finansial kamu.</p>
            </div>
            <button @click="showModal = true; editMode = false; form = { title: '', target_amount: '', current_amount: '0', deadline: '', icon: 'fa-bullseye', status: 'active' }" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Buat Target Baru
            </button>
        </div>
        
        <form method='GET' action='{{ request()->url() }}' class='flex gap-2 w-full max-w-sm mt-4 md:mt-0'>
            <input type='text' name='search' value='{{ request()->search }}' placeholder='Cari data...' class='w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50'>
            <button type='submit' class='bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition'><i class='fa-solid fa-search'></i></button>
            @if(request()->search)
                <a href='{{ request()->url() }}' class='bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-xl text-sm font-semibold transition'><i class='fa-solid fa-xmark'></i></a>
            @endif
        </form>
        

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Tujuan</th>
                        <th class="px-6 py-4">Progress Nominal</th>
                        <th class="px-6 py-4">Status & Tenggat</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80 text-slate-700">
                    @forelse($saving_goals as $goal)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-medium flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid {{ $goal->icon ?? 'fa-bullseye' }}"></i>
                            </div>
                            {{ $goal->title }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">Rp {{ number_format($goal->current_amount, 0, ',', '.') }} <span class="text-xs text-slate-400 font-normal">/ Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span></div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                                <div class="bg-emerald-400 h-1.5 rounded-full" style="width: {{ $goal->target_amount > 0 ? min(100, ($goal->current_amount / $goal->target_amount) * 100) : 0 }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg border {{ $goal->status == 'reached' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                {{ strtoupper($goal->status) }}
                            </span>
                            <div class="text-xs text-rose-500 mt-1 font-semibold">{{ $goal->deadline ? date('d M Y', strtotime($goal->deadline)) : 'No Target Date' }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="showModal = true; editMode = true; currentId = {{ $goal->id }}; form = { title: '{{ addslashes($goal->title) }}', target_amount: '{{ $goal->target_amount }}', current_amount: '{{ $goal->current_amount }}', deadline: '{{ $goal->deadline }}', icon: '{{ $goal->icon }}', status: '{{ $goal->status }}' }" class="text-indigo-600 hover:text-indigo-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('saving-goals', $goal->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus Target ini?')" class="text-rose-600 hover:text-rose-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada target tabungan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class='mt-4'>
            {{ $saving_goals->appends(['search' => request('search')])->links() }}
        </div>

        <!-- Alpine Modal -->
        <div x-show="showModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showModal = false"></div>
            <div class="bg-white rounded-3xl p-6 w-full max-w-lg z-10 shadow-2xl relative" x-transition>
                <button @click="showModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                <h3 class="text-lg font-bold text-slate-800 mb-4" x-text="editMode ? 'Edit Tabungan' : 'Tambah Target Tabungan'"></h3>
                
                <form :action="editMode ? '{{ url('saving-goals') }}/' + currentId : '{{ route('saving-goals.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Target (Resolusi)</label>
                        <input type="text" name="title" x-model="form.title" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50" required placeholder="Contoh: DP Rumah, Liburan, Dana Darurat">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Target Dibutuhkan (Rp)</label>
                            <input type="number" name="target_amount" x-model="form.target_amount" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm" required placeholder="10000000">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Terkumpul Saat Ini (Rp)</label>
                            <input type="number" name="current_amount" x-model="form.current_amount" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm" placeholder="0">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Batas Waktu (Deadline)</label>
                            <input type="date" name="deadline" x-model="form.deadline" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                            <select name="status" x-model="form.status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                                <option value="active">Active</option>
                                <option value="reached">Reached / Tercapai</option>
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
