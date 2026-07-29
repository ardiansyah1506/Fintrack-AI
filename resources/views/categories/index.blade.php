<x-app-layout title="Kelola Kategori - FinTrack AI">
    <x-slot name="header">Kelola Kategori</x-slot>
    <x-slot name="breadcrumb">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span>Kategori</span>
    </x-slot>

    <div x-data="{ 
        editId: null, 
        editName: '', 
        editType: 'expense', 
        editColor: '#6B7280', 
        editIcon: 'folder',
        openEdit(cat) {
            this.editId = cat.id;
            this.editName = cat.name;
            this.editType = cat.type;
            this.editColor = cat.color;
            this.editIcon = cat.icon;
            $dispatch('open-modal', 'edit-category');
        }
    }">

        <!-- Top Control Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <!-- Filter Tabs -->
            <div class="inline-flex p-1 rounded-xl bg-slate-200/80 border border-slate-300/60">
                <a href="{{ route('categories.index') }}" class="px-4 py-1.5 text-xs font-semibold rounded-lg transition-all {{ !$type ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    Semua ({{ $categories->count() }})
                </a>
                <a href="{{ route('categories.index', ['type' => 'expense']) }}" class="px-4 py-1.5 text-xs font-semibold rounded-lg transition-all {{ $type === 'expense' ? 'bg-white text-rose-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    Pengeluaran ({{ $expenseCategories->count() }})
                </a>
                <a href="{{ route('categories.index', ['type' => 'income']) }}" class="px-4 py-1.5 text-xs font-semibold rounded-lg transition-all {{ $type === 'income' ? 'bg-white text-emerald-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    Pemasukan ({{ $incomeCategories->count() }})
                </a>
            </div>

            <!-- Add Category Button -->
            <x-button x-on:click="$dispatch('open-modal', 'create-category')" icon="plus" variant="primary">
                Tambah Kategori
            </x-button>
        </div>

        <!-- Categories Display Grid -->
        @if($categories->isEmpty())
            <x-card>
                <x-empty-state 
                    title="Belum ada kategori" 
                    description="Buat kategori baru untuk mengelompokkan transaksi keuangan Anda."
                    icon="layer-group"
                >
                    <x-slot name="action">
                        <x-button x-on:click="$dispatch('open-modal', 'create-category')" icon="plus" variant="primary">
                            Tambah Kategori Pertama
                        </x-button>
                    </x-slot>
                </x-empty-state>
            </x-card>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($categories as $category)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:shadow-md transition-all group relative flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white shadow-sm transition-transform group-hover:scale-105" style="background-color: {{ $category->color }};">
                                    <i class="fa-solid fa-{{ $category->icon ?? 'folder' }} text-lg"></i>
                                </div>

                                <div class="flex items-center gap-1">
                                    <x-badge :variant="$category->type === 'income' ? 'success' : 'danger'" size="sm">
                                        {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </x-badge>
                                </div>
                            </div>

                            <h3 class="text-base font-bold text-slate-800 tracking-tight group-hover:text-indigo-600 transition">
                                {{ $category->name }}
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">
                                {{ $category->transactions_count }} Transaksi dicatat
                            </p>
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                            <button 
                                x-on:click="openEdit({{ json_encode($category) }})" 
                                class="px-2.5 py-1 text-xs font-medium rounded-lg text-slate-600 hover:bg-slate-100 transition"
                                title="Edit Kategori"
                            >
                                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                            </button>

                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded-lg text-rose-600 hover:bg-rose-50 transition" title="Hapus Kategori">
                                    <i class="fa-solid fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Create Category Modal -->
        <x-modal name="create-category" title="Tambah Kategori Baru">
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <x-input label="Nama Kategori" name="name" placeholder="Contoh: Gaji, Belanja, Tagihan" required icon="tag" />

                <x-select label="Jenis Kategori" name="type" required icon="layer-group">
                    <option value="expense">Pengeluaran (Expense)</option>
                    <option value="income">Pemasukan (Income)</option>
                </x-select>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input label="Warna (Hex Code)" name="color" type="color" value="#6B7280" required />
                    </div>
                    <div>
                        <x-select label="Ikon" name="icon" required icon="icons">
                            <option value="folder">Folder / Default</option>
                            <option value="utensils">Makanan (Utensils)</option>
                            <option value="cup-hot">Minuman (Coffee/Drink)</option>
                            <option value="car">Transportasi (Car)</option>
                            <option value="shopping-bag">Belanja (Shopping)</option>
                            <option value="receipt">Tagihan (Receipt)</option>
                            <option value="bolt">Listrik (Bolt)</option>
                            <option value="droplet">Air (Water)</option>
                            <option value="wifi">Internet (Wifi)</option>
                            <option value="heart">Kesehatan (Health)</option>
                            <option value="academic-cap">Pendidikan (Education)</option>
                            <option value="film">Hiburan (Film/Movie)</option>
                            <option value="banknotes">Gaji / Uang (Banknotes)</option>
                            <option value="gift">Bonus / Hadiah (Gift)</option>
                            <option value="laptop">Freelance / Laptop</option>
                            <option value="chart-bar">Investasi (Chart)</option>
                            <option value="sparkles">Cashback (Sparkles)</option>
                        </x-select>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-button x-on:click="$dispatch('close-modal', 'create-category')" variant="secondary">
                        Batal
                    </x-button>
                    <x-button type="submit" variant="primary" icon="check">
                        Simpan Kategori
                    </x-button>
                </div>
            </form>
        </x-modal>

        <!-- Edit Category Modal -->
        <x-modal name="edit-category" title="Edit Kategori">
            <form x-bind:action="'/categories/' + editId" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori *</label>
                    <input type="text" name="name" x-model="editName" required class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Kategori *</label>
                    <select name="type" x-model="editType" required class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                        <option value="expense">Pengeluaran (Expense)</option>
                        <option value="income">Pemasukan (Income)</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Warna *</label>
                        <input type="color" name="color" x-model="editColor" required class="w-full h-10 rounded-xl border border-slate-300 bg-white cursor-pointer" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Ikon *</label>
                        <select name="icon" x-model="editIcon" required class="w-full text-sm rounded-xl border border-slate-300 bg-white text-slate-900 px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                            <option value="folder">Folder / Default</option>
                            <option value="utensils">Makanan (Utensils)</option>
                            <option value="cup-hot">Minuman (Coffee/Drink)</option>
                            <option value="car">Transportasi (Car)</option>
                            <option value="shopping-bag">Belanja (Shopping)</option>
                            <option value="receipt">Tagihan (Receipt)</option>
                            <option value="bolt">Listrik (Bolt)</option>
                            <option value="droplet">Air (Water)</option>
                            <option value="wifi">Internet (Wifi)</option>
                            <option value="heart">Kesehatan (Health)</option>
                            <option value="academic-cap">Pendidikan (Education)</option>
                            <option value="film">Hiburan (Film/Movie)</option>
                            <option value="banknotes">Gaji / Uang (Banknotes)</option>
                            <option value="gift">Bonus / Hadiah (Gift)</option>
                            <option value="laptop">Freelance / Laptop</option>
                            <option value="chart-bar">Investasi (Chart)</option>
                            <option value="sparkles">Cashback (Sparkles)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <x-button x-on:click="$dispatch('close-modal', 'edit-category')" variant="secondary">
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
