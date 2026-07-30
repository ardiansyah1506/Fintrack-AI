<x-app-layout title="Kelola Transaksi - FinTrack AI">
    <x-slot name="header">Kelola Transaksi</x-slot>
    <x-slot name="breadcrumb">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span>Transaksi</span>
    </x-slot>

    <div x-data="{ 
        // Create modal state
        createType: 'expense',

        // Edit modal state
        editId: null,
        editDate: '',
        editType: 'expense',
        editCategory: '',
        editAmount: '',
        editDescription: '',
        editNotes: '',
        
        allCategories: {{ json_encode($categories) }},

        get filteredCategories() {
            return this.allCategories.filter(c => c.type === this.createType);
        },

        get editFilteredCategories() {
            return this.allCategories.filter(c => c.type === this.editType);
        },

        openEdit(tx) {
            this.editId = tx.id;
            this.editDate = tx.transaction_date.substring(0, 10);
            this.editType = tx.type;
            this.editCategory = tx.category;
            this.editAmount = tx.amount;
            this.editDescription = tx.description;
            this.editNotes = tx.notes || '';
            $dispatch('open-modal', 'edit-transaction');
        }
    }" x-init="if ('{{ request()->query('action') }}' === 'create') { $dispatch('open-modal', 'create-transaction'); }">

        <!-- Header Actions & Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <x-card padding="false">
                <div class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pemasukan</p>
                        <h3 class="text-xl font-bold text-emerald-600 mt-1">
                            {{ formatCurrency($summary['income_total']) }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 border border-emerald-100">
                        <i class="fa-solid fa-arrow-down-left text-xl"></i>
                    </div>
                </div>
            </x-card>

            <x-card padding="false">
                <div class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pengeluaran</p>
                        <h3 class="text-xl font-bold text-rose-600 mt-1">
                            {{ formatCurrency($summary['expense_total']) }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 border border-rose-100">
                        <i class="fa-solid fa-arrow-up-right text-xl"></i>
                    </div>
                </div>
            </x-card>

            <x-card padding="false">
                <div class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Selisih (Saldo)</p>
                        <h3 class="text-xl font-bold {{ $summary['balance'] >= 0 ? 'text-indigo-600' : 'text-rose-600' }} mt-1">
                            {{ formatCurrency($summary['balance']) }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                        <i class="fa-solid fa-scale-balanced text-xl"></i>
                    </div>
                </div>
            </x-card>

            <x-card padding="false">
                <div class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jumlah Transaksi</p>
                        <h3 class="text-xl font-bold text-slate-800 mt-1">
                            {{ $summary['total_count'] }} Transaksi
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-600 border border-slate-200">
                        <i class="fa-solid fa-list-check text-xl"></i>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Quick Period Preset Buttons Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
            <div class="inline-flex p-1 rounded-xl bg-slate-200/80 border border-slate-300/60 flex-wrap">
                <a href="{{ route('transactions.index', array_merge(request()->except('period', 'date_start', 'date_end', 'page'))) }}" 
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all {{ !request('period') && !request('date_start') ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-globe mr-1"></i> Semua Waktu
                </a>
                <a href="{{ route('transactions.index', array_merge(request()->except('date_start', 'date_end', 'page'), ['period' => 'today'])) }}" 
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all {{ request('period') === 'today' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-calendar-day mr-1"></i> Hari Ini (Harian)
                </a>
                <a href="{{ route('transactions.index', array_merge(request()->except('date_start', 'date_end', 'page'), ['period' => 'this_week'])) }}" 
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all {{ request('period') === 'this_week' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-calendar-week mr-1"></i> Minggu Ini (Mingguan)
                </a>
                <a href="{{ route('transactions.index', array_merge(request()->except('date_start', 'date_end', 'page'), ['period' => 'this_month'])) }}" 
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all {{ request('period') === 'this_month' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-calendar-days mr-1"></i> Bulan Ini (Bulanan)
                </a>
            </div>

            <x-button x-on:click="$dispatch('open-modal', 'create-transaction')" variant="success" size="sm" icon="plus">
                Catat Transaksi Baru
            </x-button>
        </div>

        <!-- Search & Filter Card -->
        <x-card class="mb-6">
            <form action="{{ route('transactions.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <x-input name="search" placeholder="Cari deskripsi / catatan / kategori..." value="{{ request('search') }}" icon="magnifying-glass" />
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <x-select name="type" placeholder="Semua Jenis" icon="filter">
                            <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </x-select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <x-select name="category" placeholder="Semua Kategori" icon="layer-group">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ ucfirst($cat->type) }})
                                </option>
                            @endforeach
                        </x-select>
                    </div>

                    <!-- Filter Periode Presets -->
                    <div>
                        <x-select name="period" placeholder="Semua Periode" icon="clock">
                            <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Hari Ini (Harian)</option>
                            <option value="this_week" {{ request('period') === 'this_week' ? 'selected' : '' }}>Minggu Ini (Mingguan)</option>
                            <option value="this_month" {{ request('period') === 'this_month' ? 'selected' : '' }}>Bulan Ini (Bulanan)</option>
                        </x-select>
                    </div>

                    <!-- Custom Date Start (Optional) -->
                    <div>
                        <x-input type="date" name="date_start" value="{{ request('date_start') }}" placeholder="Mulai Tanggal" />
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                    <div class="flex items-center gap-2">
                        <x-button type="submit" variant="primary" size="sm" icon="filter">
                            Terapkan Filter
                        </x-button>
                        <x-button href="{{ route('transactions.index') }}" variant="ghost" size="sm" icon="rotate-left">
                            Reset
                        </x-button>
                    </div>
                </div>
            </form>
        </x-card>

        <!-- Transactions Table -->
        <x-card padding="false">
            @if($transactions->isEmpty())
                <x-empty-state 
                    title="Tidak ada transaksi" 
                    description="Belum ada catatan transaksi yang sesuai dengan filter atau periode Anda."
                    icon="receipt"
                >
                    <x-slot name="action">
                        <x-button x-on:click="$dispatch('open-modal', 'create-transaction')" variant="primary" icon="plus">
                            Tambah Transaksi Pertama
                        </x-button>
                    </x-slot>
                </x-empty-state>
            @else
                <x-table :headers="['Tanggal', 'Jenis', 'Kategori', 'Deskripsi & Catatan', 'Nominal', 'Aksi']">
                    @foreach($transactions as $tx)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 font-medium text-slate-700 whitespace-nowrap">
                                {{ formatDate($tx->transaction_date) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge :variant="$tx->type === 'income' ? 'success' : 'danger'" size="sm" :icon="$tx->type === 'income' ? 'arrow-down-left' : 'arrow-up-right'">
                                    {{ $tx->type === 'income' ? 'Income' : 'Expense' }}
                                </x-badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl bg-slate-100 border border-slate-200/60 text-xs font-semibold text-slate-700">
                                    <i class="fa-solid fa-folder text-indigo-500 text-xs"></i>
                                    <span>{{ $tx->category }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-800">{{ $tx->description }}</div>
                                @if($tx->notes)
                                    <div class="text-xs text-slate-400 mt-0.5">{{ $tx->notes }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold whitespace-nowrap {{ $tx->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $tx->type === 'income' ? '+' : '-' }} {{ formatCurrency($tx->amount) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <button 
                                        x-on:click="openEdit({{ json_encode($tx) }})" 
                                        class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-slate-100 transition"
                                        title="Edit Transaksi"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <form action="{{ route('transactions.destroy', $tx->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Transaksi">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-table>

                <x-pagination :paginator="$transactions" />
            @endif
        </x-card>

        <!-- Create Transaction Modal -->
        <x-modal name="create-transaction" title="Catat Transaksi Baru">
            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input label="Tanggal Transaksi" name="transaction_date" type="date" value="{{ date('Y-m-d') }}" required />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Transaksi *</label>
                        <select name="type" x-model="createType" required class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                            <option value="expense">Pengeluaran (Expense)</option>
                            <option value="income">Pemasukan (Income)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Kategori *</label>
                    <select name="category" required class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                        <option value="">Pilih Kategori</option>
                        <template x-for="cat in filteredCategories" :key="cat.id">
                            <option :value="cat.name" x-text="cat.name"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <x-input label="Nominal (Rp)" name="amount" type="number" step="0.01" min="1" placeholder="Contoh: 150000" required icon="money-bill-wave" />
                </div>

                <div>
                    <x-input label="Deskripsi Transaksi" name="description" placeholder="Contoh: Makan Siang Resto Padang" required icon="heading" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" rows="2" placeholder="Catatan opsional..." class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-button x-on:click="$dispatch('close-modal', 'create-transaction')" variant="secondary">
                        Batal
                    </x-button>
                    <x-button type="submit" variant="primary" icon="check">
                        Simpan Transaksi
                    </x-button>
                </div>
            </form>
        </x-modal>

        <!-- Edit Transaction Modal -->
        <x-modal name="edit-transaction" title="Edit Transaksi">
            <form x-bind:action="'/transactions/' + editId" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal *</label>
                        <input type="date" name="transaction_date" x-model="editDate" required class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Jenis *</label>
                        <select name="type" x-model="editType" required class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                            <option value="expense">Pengeluaran (Expense)</option>
                            <option value="income">Pemasukan (Income)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Kategori *</label>
                    <select name="category" x-model="editCategory" required class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                        <option value="">Pilih Kategori</option>
                        <template x-for="cat in editFilteredCategories" :key="cat.id">
                            <option :value="cat.name" x-text="cat.name" :selected="cat.name == editCategory"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Nominal (Rp) *</label>
                    <input type="number" step="0.01" name="amount" x-model="editAmount" required class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi *</label>
                    <input type="text" name="description" x-model="editDescription" required class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Catatan</label>
                    <textarea name="notes" x-model="editNotes" rows="2" class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-button x-on:click="$dispatch('close-modal', 'edit-transaction')" variant="secondary">
                        Batal
                    </x-button>
                    <x-button type="submit" variant="primary" icon="check">
                        Simpan Perubahan
                    </x-button>
                </div>
            </form>
        </x-modal>

    </div>
</x-app-layout>
