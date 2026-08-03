<x-app-layout title="Control Center - FinTrack AI OS">
    <x-slot name="header">AI OS Dashboard</x-slot>
    <x-slot name="breadcrumb">Home / Dashboards / Overview</x-slot>

    <div class="space-y-6 text-slate-800 font-sans">
        <!-- AI Core Status Banner -->
        <div class="bg-gradient-to-r from-emerald-900 to-slate-900 rounded-3xl p-6 text-white shadow-xl flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-emerald-500/20 flex items-center justify-center border border-emerald-500/30">
                    <i class="fa-solid fa-microchip text-emerald-400 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">N8n + Gemini Engine Active</h2>
                    <p class="text-sm text-emerald-100/70">Orchestrating financial intents via Telegram NLP</p>
                </div>
            </div>
            <div class="hidden md:flex gap-6 text-right">
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">Bot Latency</p>
                    <p class="text-lg font-semibold text-emerald-400 mt-1">42ms</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">Active Memory</p>
                    <p class="text-lg font-semibold text-emerald-400 mt-1">12 Keys</p>
                </div>
            </div>
        </div>

        <!-- Summary Widgets (7 Cols) -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 lg:gap-5">
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-wallet text-slate-300"></i> Current Balance</p>
                <h3 class="text-2xl font-bold {{ $summary['current_balance'] >= 0 ? 'text-slate-800' : 'text-rose-600' }} mt-2">{{ formatCurrency($summary['current_balance']) }}</h3>
            </div>
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-arrow-down text-emerald-500"></i> Monthly Income</p>
                <h3 class="text-2xl font-bold text-emerald-500 mt-2">{{ formatCurrency($summary['monthly_income']) }}</h3>
            </div>
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-arrow-up text-rose-500"></i> Monthly Expense</p>
                <h3 class="text-2xl font-bold text-rose-500 mt-2">{{ formatCurrency($summary['monthly_expense']) }}</h3>
            </div>
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-file-invoice-dollar text-amber-500"></i> Upcoming Bills</p>
                <h3 class="text-2xl font-bold text-amber-500 mt-2">{{ $bills_count }} Due</h3>
            </div>
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-bell text-indigo-500"></i> Upcoming Task</p>
                <h3 class="text-2xl font-bold text-indigo-500 mt-2">{{ $reminders_count }} Reminder</h3>
            </div>
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-brands fa-telegram text-blue-500"></i> N8N Sync</p>
                <h3 class="text-2xl font-bold text-blue-500 mt-2">Active</h3>
            </div>
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-code-branch text-purple-500"></i> Workflow</p>
                <h3 class="text-2xl font-bold text-purple-500 mt-2">Running</h3>
            </div>
        </div>

        <!-- 6 Main Charts Matrix -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- 1. Income vs Expense -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col">
                <h4 class="text-sm font-bold text-slate-700 mb-4">Income vs Expense (This Month)</h4>
                <div class="flex-1 relative min-h-[200px]">
                    <canvas id="chartIncomeExpense"></canvas>
                </div>
            </div>
            <!-- 2. Expense Category -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col">
                <h4 class="text-sm font-bold text-slate-700 mb-4">Expense by Category</h4>
                <div class="flex-1 relative min-h-[200px] flex items-center justify-center">
                    <canvas id="chartExpenseCategory"></canvas>
                </div>
            </div>
            <!-- 3. Cashflow Trend -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col">
                <h4 class="text-sm font-bold text-slate-700 mb-4">Daily Cashflow</h4>
                <div class="flex-1 relative min-h-[200px]">
                    <canvas id="chartCashflow"></canvas>
                </div>
            </div>
            <!-- 4. Monthly Trend -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col">
                <h4 class="text-sm font-bold text-slate-700 mb-4">Monthly Trend (6 Months)</h4>
                <div class="flex-1 relative min-h-[200px]">
                    <canvas id="chartMonthlyTrend"></canvas>
                </div>
            </div>
            <!-- 5. Budget Progress -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col">
                <h4 class="text-sm font-bold text-slate-700 mb-4">Top Budget Progress</h4>
                <div class="flex-1 relative min-h-[200px]">
                    <canvas id="chartBudgetProgress"></canvas>
                </div>
            </div>
            <!-- 6. Saving Progress -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col">
                <h4 class="text-sm font-bold text-slate-700 mb-4">Target Saving Progress</h4>
                <div class="flex-1 relative min-h-[200px]">
                    <canvas id="chartSavingProgress"></canvas>
                </div>
            </div>
        </div>

        <!-- AI Assistant Blocks -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Latest AI Insight -->
            <div class="bg-gradient-to-br from-emerald-50 to-white rounded-3xl p-6 shadow-sm border border-emerald-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex justify-center items-center">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <h4 class="font-bold text-emerald-900 leading-tight">AI<br>Insight</h4>
                    </div>
                    <p class="text-sm text-slate-700 leading-relaxed font-medium">Anda berhasil menekan pengeluaran 'Makan di Luar' sebesar 30%. Sisa budget dapat dialokasikan ke 'Tabungan Liburan'.</p>
                </div>
                <div class="mt-4 flex gap-2">
                    <span class="px-2 py-1 bg-white border border-emerald-200 text-emerald-600 rounded-lg text-[10px] font-bold">Optimization</span>
                </div>
            </div>

            <!-- Prediction Card -->
            <div class="bg-gradient-to-br from-indigo-50 to-white rounded-3xl p-6 shadow-sm border border-indigo-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex justify-center items-center">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h4 class="font-bold text-indigo-900 leading-tight">AI<br>Prediction</h4>
                    </div>
                    <p class="text-sm text-slate-700 leading-relaxed font-medium">Model regresi memprediksi saldo akhir bulan Anda mencapai surplus Rp 5.200.000.</p>
                </div>
                <div class="mt-4 flex gap-2">
                    <span class="px-2 py-1 bg-white border border-indigo-200 text-indigo-600 rounded-lg text-[10px] font-bold">Accuracy: 85%</span>
                </div>
            </div>

            <!-- AI Recommendation -->
            <div class="bg-gradient-to-br from-amber-50 to-white rounded-3xl p-6 shadow-sm border border-amber-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex justify-center items-center"><i class="fa-solid fa-lightbulb"></i></div>
                        <h4 class="font-bold text-amber-900 leading-tight">AI<br>Recommendation</h4>
                    </div>
                    <p class="text-sm text-slate-700 leading-relaxed font-medium">Beralih ke model langganan tahunan untuk asuransi dan software dapat menghemat Rp 750.000 per tahun.</p>
                </div>
                <div class="mt-4 flex gap-2">
                    <span class="px-2 py-1 bg-white border border-amber-200 text-amber-600 rounded-lg text-[10px] font-bold">Smart Saving</span>
                </div>
            </div>

            <!-- AI Warning -->
            <div class="bg-gradient-to-br from-rose-50 to-white rounded-3xl p-6 shadow-sm border border-rose-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex justify-center items-center"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <h4 class="font-bold text-rose-900 leading-tight">AI<br>Warning</h4>
                    </div>
                    <p class="text-sm text-slate-700 leading-relaxed font-medium">Pengeluaran kategori 'Hiburan' telah melebihi batas upper budget minggu ini sebesar 12%. Harap rem pengeluaran diskresi.</p>
                </div>
                <div class="mt-4 flex gap-2">
                    <span class="px-2 py-1 bg-white border border-rose-200 text-rose-600 rounded-lg text-[10px] font-bold">High Severity</span>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h4 class="font-bold text-slate-800">Recent Automated Transactions</h4>
                <a href="{{ route('transactions.index') }}" class="text-emerald-600 text-sm font-semibold hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold tracking-wider">TANGGAL</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">DESKRIPSI</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">KATEGORI</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">SOURCE</th>
                            <th class="px-6 py-4 font-semibold tracking-wider text-right">JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recent_transactions as $tx)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 text-slate-500 break-keep">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-medium text-slate-700">{{ $tx->description }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-indigo-100 text-indigo-600 px-2.5 py-1 rounded-lg text-xs font-bold">{{ $tx->category }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg text-xs font-bold">
                                    @if($tx->source === 'telegram' || stripos($tx->notes, 'telegram') !== false)
                                        <i class="fa-brands fa-telegram mr-1 text-blue-500"></i> Telegram
                                    @elseif($tx->source === 'bot' || $tx->source === 'n8n' || stripos($tx->notes, 'n8n') !== false)
                                        <i class="fa-solid fa-robot mr-1 text-emerald-500"></i> Automation
                                    @else
                                        <i class="fa-solid fa-user mr-1 text-slate-500"></i> Apps / Web
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-bold {{ $tx->type === 'income' ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $tx->type === 'income' ? '+' : '-' }} {{ formatCurrency($tx->amount) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada transaksi terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js Setup Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global Settings
            Chart.defaults.font.family = "'Outfit', sans-serif";
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.scale.grid.color = '#f1f5f9';
            Chart.defaults.scale.grid.borderColor = 'transparent';

            // 1. Income vs Expense (Bar)
            new Chart(document.getElementById('chartIncomeExpense'), {
                type: 'bar',
                data: @json($income_vs_expense_chart),
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

            // 2. Expense Category (Doughnut)
            new Chart(document.getElementById('chartExpenseCategory'), {
                type: 'doughnut',
                data: @json($expense_by_category_chart),
                options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'right' } } }
            });

            // 3. Cashflow Trend (Line) (Using Weekly Trend Data)
            new Chart(document.getElementById('chartCashflow'), {
                type: 'line',
                data: @json($weekly_trend_chart),
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

            // 4. Monthly Trend (Line)
            new Chart(document.getElementById('chartMonthlyTrend'), {
                type: 'line',
                data: @json($monthly_trend_chart),
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

            // Prepare Budget data
            const budgets = @json($budgetProgress ?? []);
            const budgetLabels = budgets.map(b => b.category);
            const budgetData = budgets.map(b => b.percentage);
            const budgetColors = budgets.map(b => b.status_color === 'red' ? '#f43f5e' : (b.status_color === 'yellow' ? '#f59e0b' : '#10b981'));

            // 5. Budget Progress (Horizontal Bar)
            new Chart(document.getElementById('chartBudgetProgress'), {
                type: 'bar',
                data: {
                    labels: budgetLabels.length ? budgetLabels : ['Belum ada budget'],
                    datasets: [{
                        label: 'Usage (%)',
                        data: budgetData.length ? budgetData : [0],
                        backgroundColor: budgetLabels.length ? budgetColors : ['#e2e8f0'],
                        borderRadius: 6
                    }]
                },
                options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, scales: { x: { max: 100 } }, plugins: { legend: { display: false } } }
            });

            // Prepare Saving data
            const savings = @json($savingGoals ?? []);
            const savingLabels = savings.map(s => s.name);
            const savingData = savings.map(s => s.target_amount > 0 ? Math.round((s.current_amount / s.target_amount)*100) : 0);
            
            // 6. Saving Progress (Polar Area)
            new Chart(document.getElementById('chartSavingProgress'), {
                type: 'polarArea',
                data: {
                    labels: savingLabels.length ? savingLabels : ['Belum ada target'],
                    datasets: [{
                        data: savingData.length ? savingData : [0],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899', '#f43f5e'],
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right' } } }
            });
        });
    </script>
</x-app-layout>
