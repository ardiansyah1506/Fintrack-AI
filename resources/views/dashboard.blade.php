<x-app-layout title="Dashboard Keuangan - FinTrack AI">
    <x-slot name="header">Dashboard Keuangan</x-slot>

    <div class="space-y-6">
        <!-- 5 Summary Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Saldo Saat Ini -->
            <x-card padding="false" class="border-l-4 border-l-indigo-600">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Saldo Saat Ini</p>
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-wallet text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold {{ $summary['current_balance'] >= 0 ? 'text-slate-900' : 'text-rose-600' }} mt-2">
                        {{ formatCurrency($summary['current_balance']) }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Akumulasi seluruh transaksi</p>
                </div>
            </x-card>

            <!-- Income Bulan Ini -->
            <x-card padding="false" class="border-l-4 border-l-emerald-500">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Income Bulan Ini</p>
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i class="fa-solid fa-arrow-down-left text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-emerald-600 mt-2">
                        {{ formatCurrency($summary['monthly_income']) }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Bulan {{ date('F Y') }}</p>
                </div>
            </x-card>

            <!-- Expense Bulan Ini -->
            <x-card padding="false" class="border-l-4 border-l-rose-500">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Expense Bulan Ini</p>
                        <div class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600">
                            <i class="fa-solid fa-arrow-up-right text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-rose-600 mt-2">
                        {{ formatCurrency($summary['monthly_expense']) }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Bulan {{ date('F Y') }}</p>
                </div>
            </x-card>

            <!-- Selisih Income vs Expense -->
            <x-card padding="false" class="border-l-4 border-l-amber-500">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Selisih Bulan Ini</p>
                        <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                            <i class="fa-solid fa-scale-balanced text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold {{ $summary['monthly_balance'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }} mt-2">
                        {{ formatCurrency($summary['monthly_balance']) }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Net Cashflow Bulan Ini</p>
                </div>
            </x-card>

            <!-- Total Transaksi -->
            <x-card padding="false" class="border-l-4 border-l-purple-500">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jumlah Transaksi</p>
                        <div class="w-8 h-8 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                            <i class="fa-solid fa-receipt text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mt-2">
                        {{ $summary['total_transactions'] }} Data
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Tercatat di sistem</p>
                </div>
            </x-card>
        </div>

        <!-- Main Analytics Chart Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Income vs Expense Chart -->
            <x-card title="Pemasukan vs Pengeluaran (6 Bulan)" subtitle="Perbandingan arus kas bulanan" class="lg:col-span-2">
                <x-chart id="incomeVsExpenseChart" type="bar" :data="$income_vs_expense_chart" height="300" />
            </x-card>

            <!-- Expense by Category Chart -->
            <x-card title="Pengeluaran per Kategori" subtitle="Distribusi pengeluaran bulan ini">
                <x-chart id="expenseByCategoryChart" type="doughnut" :data="$expense_by_category_chart" height="300" />
            </x-card>
        </div>

        <!-- Secondary Charts & Feed -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Weekly Trend Chart -->
            <x-card title="Trend Transaksi Mingguan" subtitle="Pergerakan cashflow per minggu bulan ini">
                <x-chart id="weeklyTrendChart" type="line" :data="$weekly_trend_chart" height="260" />
            </x-card>

            <!-- Monthly Trend Chart -->
            <x-card title="Trend Transaksi Bulanan" subtitle="Evaluasi pergerakan sepanjang tahun">
                <x-chart id="monthlyTrendChart" type="line" :data="$monthly_trend_chart" height="260" />
            </x-card>

            <!-- Recent Transactions Widget -->
            <x-card title="Transaksi Terbaru" subtitle="5 catatan transaksi terakhir" padding="false">
                <x-slot name="action">
                    <a href="{{ route('transactions.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">
                        Lihat Semua <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </x-slot>

                <div class="divide-y divide-slate-100">
                    @forelse($recent_transactions as $tx)
                        <div class="p-4 flex items-center justify-between gap-3 hover:bg-slate-50/50 transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs" style="background-color: {{ $tx->category->color ?? '#6B7280' }};">
                                    <i class="fa-solid fa-{{ $tx->category->icon ?? 'folder' }} text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs font-semibold text-slate-800 truncate">{{ $tx->description }}</h4>
                                    <p class="text-[11px] text-slate-400">{{ formatDate($tx->transaction_date) }} • {{ $tx->category->name ?? 'Kategori' }}</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-xs font-bold {{ $tx->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $tx->type === 'income' ? '+' : '-' }} {{ formatCurrency($tx->amount) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400">Belum ada transaksi.</div>
                    @endforelse
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
