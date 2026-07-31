<x-app-layout title="Recurring Bills - Control Center">
    <x-slot name="header">Recurring Bills</x-slot>
    
    <div x-data="{ showModal: false, editMode: false, currentId: null, form: { name: '', category: '', amount: '', billing_date: '', repeat: 'monthly', auto_create_transaction: false, reminder_before: 1, status: 'active' } }" class="space-y-6 text-slate-800 font-sans relative">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Tagihan Rutin & Langganan</h2>
                <p class="text-xs text-slate-400 mt-1">N8n akan otomatis mencatat pengeluaran berdasarkan jadwal Tagihan di sini.</p>
            </div>
            <button @click="showModal = true; editMode = false; form = { name: '', category: '', amount: '', billing_date: '', repeat: 'monthly', auto_create_transaction: true, reminder_before: 1, status: 'active' }" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Tagihan Baru
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
                        <th class="px-6 py-4">Nama Layanan</th>
                        <th class="px-6 py-4">Siklus Tagihan</th>
                        <th class="px-6 py-4">Biaya</th>
                        <th class="px-6 py-4">Status & Automation</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80 text-slate-700">
                    @forelse($bills as $bill)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-medium flex items-center gap-3">
                            <i class="fa-solid fa-file-invoice-dollar text-emerald-500 text-lg"></i>
                            <div>
                                <span class="block">{{ $bill->name }}</span>
                                <span class="text-[10px] uppercase font-bold text-slate-400">{{ $bill->category }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            Setiap tanggal <span class="font-bold">{{ date('d', strtotime($bill->billing_date)) }}</span> ({{ ucfirst($bill->repeat) }})
                        </td>
                        <td class="px-6 py-4 font-bold text-rose-500">
                            Rp {{ number_format($bill->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg border {{ $bill->status == 'active' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                {{ strtoupper($bill->status) }}
                            </span>
                            @if($bill->auto_create_transaction)
                            <div class="mt-1 text-[10px] font-semibold text-emerald-500"><i class="fa-solid fa-robot mr-1"></i> Auto Pay / Book</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="showModal = true; editMode = true; currentId = {{ $bill->id }}; form = { name: '{{ addslashes($bill->name) }}', category: '{{ addslashes($bill->category) }}', amount: '{{ $bill->amount }}', billing_date: '{{ $bill->billing_date }}', repeat: '{{ $bill->repeat }}', auto_create_transaction: {{ $bill->auto_create_transaction ? 'true' : 'false' }}, reminder_before: '{{ $bill->reminder_before }}', status: '{{ $bill->status }}' }" class="text-indigo-600 hover:text-indigo-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('bills', $bill->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Berhenti berlangganan dan hapus tagihan ini?')" class="text-rose-600 hover:text-rose-800 mx-2 text-xs font-semibold"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada tagihan terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class='mt-4'>
            {{ $bills->appends(['search' => request('search')])->links() }}
        </div>

        <!-- Alpine Modal -->
        <div x-show="showModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showModal = false"></div>
            <div class="bg-white rounded-3xl p-6 w-full max-w-lg z-10 shadow-2xl relative" x-transition>
                <button @click="showModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                <h3 class="text-lg font-bold text-slate-800 mb-4" x-text="editMode ? 'Edit Tagihan' : 'Tambah Tagihan Rutin'"></h3>
                
                <form :action="editMode ? '{{ url('bills') }}/' + currentId : '{{ route('bills.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Layanan</label>
                            <input type="text" name="name" x-model="form.name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50" required placeholder="Netflix, Listrik...">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kategori API</label>
                            <input type="text" name="category" x-model="form.category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm" required placeholder="Hiburan, Utilitas">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nominal Tagihan</label>
                            <input type="number" name="amount" x-model="form.amount" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm" required placeholder="185000">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Siklus</label>
                            <select name="repeat" x-model="form.repeat" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                                <option value="monthly">Bulanan</option>
                                <option value="yearly">Tahunan</option>
                                <option value="weekly">Mingguan</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tanggal Jatuh Tempo (Base)</label>
                            <input type="date" name="billing_date" x-model="form.billing_date" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Ingatkan H- (Hari)</label>
                            <input type="number" name="reminder_before" x-model="form.reminder_before" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <input type="checkbox" name="auto_create_transaction" id="act" x-model="form.auto_create_transaction" class="w-4 h-4 text-emerald-600 rounded">
                        <label for="act" class="text-sm font-semibold text-slate-700">Auto Catat / Bayar (N8n Automation)</label>
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
