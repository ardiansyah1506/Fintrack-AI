<x-app-layout title="Laporan Keuangan - FinTrack AI">
    <x-slot name="header">Laporan Keuangan</x-slot>
    <x-slot name="breadcrumb">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span>Laporan</span>
    </x-slot>

    <div class="space-y-6">

        <!-- Report Period Tabs & Filter -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <!-- Tabs Switcher -->
            <div class="inline-flex p-1 rounded-xl bg-slate-200/80 border border-slate-300/60">
                <a href="{{ route('reports.index', ['period' => 'daily', 'date' => request('date')]) }}" 
                   class="px-5 py-2 text-xs font-semibold rounded-lg transition-all {{ $period === 'daily' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-calendar-day mr-1.5"></i> Laporan Harian
                </a>
                <a href="{{ route('reports.index', ['period' => 'weekly', 'date' => request('date')]) }}" 
                   class="px-5 py-2 text-xs font-semibold rounded-lg transition-all {{ $period === 'weekly' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-calendar-week mr-1.5"></i> Laporan Mingguan
                </a>
                <a href="{{ route('reports.index', ['period' => 'monthly', 'month' => request('month'), 'year' => request('year')]) }}" 
                   class="px-5 py-2 text-xs font-semibold rounded-lg transition-all {{ $period === 'monthly' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-calendar-days mr-1.5"></i> Laporan Bulanan
                </a>
            </div>

            <!-- Date Selector Filter Form -->
            <form action="{{ route('reports.index') }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="period" value="{{ $period }}">

                @if($period === 'monthly')
                    <select name="month" class="text-xs font-semibold rounded-xl border border-slate-300 bg-white text-slate-800 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ sprintf('%02d', $m) }}" {{ (request('month') ?? date('m')) == sprintf('%02d', $m) ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>

                    <select name="year" class="text-xs font-semibold rounded-xl border border-slate-300 bg-white text-slate-800 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(range(date('Y') - 2, date('Y') + 1) as $y)
                            <option value="{{ $y }}" {{ (request('year') ?? date('Y')) == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <input type="date" name="date" value="{{ request('date') ?? date('Y-m-d') }}" class="text-xs font-semibold rounded-xl border border-slate-300 bg-white text-slate-800 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @endif

                <x-button type="submit" variant="primary" size="sm" icon="filter">
                    Tampilkan
                </x-button>
            </form>
        </div>

        <!-- Summary Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-card padding="false">
                <div class="p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pemasukan</p>
                        <h3 class="text-2xl font-bold text-emerald-600 mt-1">
                            {{ formatCurrency($reportData['summary']['total_income']) }}
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
                        <h3 class="text-2xl font-bold text-rose-600 mt-1">
                            {{ formatCurrency($reportData['summary']['total_expense']) }}
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
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Net Cashflow (Selisih)</p>
                        <h3 class="text-2xl font-bold {{ $reportData['summary']['net_balance'] >= 0 ? 'text-indigo-600' : 'text-rose-600' }} mt-1">
                            {{ formatCurrency($reportData['summary']['net_balance']) }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                        <i class="fa-solid fa-scale-balanced text-xl"></i>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Breakdown Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Expense Category Breakdown Table -->
            <x-card title="Pengeluaran per Kategori" subtitle="Distribusi pengeluaran periode ini" class="lg:col-span-1">
                @if(empty($reportData['categories_breakdown']))
                    <div class="py-8 text-center text-xs text-slate-400">Tidak ada pengeluaran pada periode ini.</div>
                @else
                    <div class="space-y-3">
                        @foreach($reportData['categories_breakdown'] as $cat)
                            <div>
                                <div class="flex items-center justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-700">{{ $cat['name'] }}</span>
                                    <span class="font-bold text-slate-900">{{ formatCurrency($cat['total']) }} ({{ $cat['percentage'] }}%)</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-300" style="width: {{ $cat['percentage'] }}%; background-color: {{ $cat['color'] }};"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-card>

            <!-- Detailed Transactions Feed in Period -->
            <x-card title="Rincian Transaksi Periode" subtitle="Semua catatan transaksi dalam rentang tanggal ini" padding="false" class="lg:col-span-2">
                @if($reportData['transactions']->isEmpty())
                    <x-empty-state 
                        title="Tidak ada transaksi" 
                        description="Tidak ada transaksi yang tercatat dalam periode laporan ini."
                        icon="receipt"
                    />
                @else
                    <x-table :headers="['Tanggal', 'Jenis', 'Kategori', 'Deskripsi', 'Nominal']">
                        @foreach($reportData['transactions'] as $tx)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-3.5 font-medium text-slate-700 whitespace-nowrap text-xs">
                                    {{ formatDate($tx->transaction_date) }}
                                </td>
                                <td class="px-6 py-3.5 whitespace-nowrap">
                                    <x-badge :variant="$tx->type === 'income' ? 'success' : 'danger'" size="sm">
                                        {{ ucfirst($tx->type) }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-3.5 whitespace-nowrap text-xs text-slate-600">
                                    {{ $tx->category }}
                                </td>
                                <td class="px-6 py-3.5 text-xs text-slate-800 font-medium">
                                    {{ $tx->description }}
                                </td>
                                <td class="px-6 py-3.5 text-xs font-bold whitespace-nowrap {{ $tx->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $tx->type === 'income' ? '+' : '-' }} {{ formatCurrency($tx->amount) }}
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                @endif
            </x-card>
        </div>

    </div>
</x-app-layout>
