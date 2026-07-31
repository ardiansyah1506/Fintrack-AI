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

        <!-- Summary Widgets (5 Cols) -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-wallet text-slate-300"></i> Current Balance</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-2">Rp 24.500.000</h3>
            </div>
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-arrow-down text-emerald-500"></i> Today's Income</p>
                <h3 class="text-2xl font-bold text-emerald-500 mt-2">Rp 2.000.000</h3>
            </div>
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-arrow-up text-rose-500"></i> Today's Expense</p>
                <h3 class="text-2xl font-bold text-rose-500 mt-2">Rp 350.000</h3>
            </div>
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-file-invoice-dollar text-amber-500"></i> Upcoming Bills</p>
                <h3 class="text-2xl font-bold text-amber-500 mt-2">3 Due</h3>
            </div>
            <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2"><i class="fa-solid fa-bell text-indigo-500"></i> Upcoming Task</p>
                <h3 class="text-2xl font-bold text-indigo-500 mt-2">1 Reminder</h3>
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Latest AI Insight -->
            <div class="bg-gradient-to-br from-emerald-50 to-white rounded-3xl p-6 shadow-sm border border-emerald-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex justify-center items-center">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <h4 class="font-bold text-emerald-900">Latest AI Insight</h4>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed font-medium">Berdasarkan data minggu ini, Anda berhasil menekan pengeluaran 'Makan di Luar' sebesar 30%. Sisa budget dapat dialokasikan ke 'Tabungan Liburan'. Teruskan kebiasaan baik ini!</p>
                <div class="mt-4 flex gap-2">
                    <span class="px-3 py-1 bg-white border border-emerald-200 text-emerald-600 rounded-lg text-xs font-bold">Optimization</span>
                    <span class="px-3 py-1 bg-white border border-emerald-200 text-emerald-600 rounded-lg text-xs font-bold">Generated 2h ago</span>
                </div>
            </div>

            <!-- Prediction Card -->
            <div class="bg-gradient-to-br from-indigo-50 to-white rounded-3xl p-6 shadow-sm border border-indigo-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex justify-center items-center">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h4 class="font-bold text-indigo-900">AI Financial Prediction</h4>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed font-medium">Model regresi Gemini memprediksi bahwa saldo akhir bulan Anda akan mencapai surplus **Rp 5.200.000**, dengan tingkat akurasi (confidence level) 85%.</p>
                <div class="mt-4 flex gap-2">
                    <span class="px-3 py-1 bg-white border border-indigo-200 text-indigo-600 rounded-lg text-xs font-bold">Accuracy: 85%</span>
                    <span class="px-3 py-1 bg-white border border-indigo-200 text-indigo-600 rounded-lg text-xs font-bold">Trend: Positive</span>
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
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 text-slate-500 break-keep">31 Jul 2026</td>
                            <td class="px-6 py-4 font-medium text-slate-700">Makan Siang Bareng</td>
                            <td class="px-6 py-4">
                                <span class="bg-rose-100 text-rose-600 px-2.5 py-1 rounded-lg text-xs font-bold">Makan</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg text-xs font-bold"><i class="fa-brands fa-telegram mr-1"></i> Telegram AI</span>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-rose-500">- Rp 45.000</td>
                        </tr>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 text-slate-500 break-keep">30 Jul 2026</td>
                            <td class="px-6 py-4 font-medium text-slate-700">Gaji Karyawan</td>
                            <td class="px-6 py-4">
                                <span class="bg-emerald-100 text-emerald-600 px-2.5 py-1 rounded-lg text-xs font-bold">Gaji</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-emerald-100 text-emerald-600 px-2.5 py-1 rounded-lg text-xs font-bold"><i class="fa-solid fa-robot mr-1"></i> n8n Automation</span>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-emerald-500">+ Rp 15.000.000</td>
                        </tr>
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
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [
                        { label: 'Income', data: [5000, 2000, 15000, 3000], backgroundColor: '#10b981', borderRadius: 6 },
                        { label: 'Expense', data: [2000, 2500, 1800, 4000], backgroundColor: '#f43f5e', borderRadius: 6 }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

            // 2. Expense Category (Doughnut)
            new Chart(document.getElementById('chartExpenseCategory'), {
                type: 'doughnut',
                data: {
                    labels: ['Makan', 'Transport', 'Hiburan', 'Belanja'],
                    datasets: [{
                        data: [45, 20, 15, 20],
                        backgroundColor: ['#f43f5e', '#f59e0b', '#8b5cf6', '#0ea5e9'],
                        borderWidth: 0
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'right' } } }
            });

            // 3. Cashflow Trend (Line)
            new Chart(document.getElementById('chartCashflow'), {
                type: 'line',
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7'],
                    datasets: [{
                        label: 'Gross',
                        data: [10, 15, 8, 20, 18, 30, 25],
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            // 4. Monthly Trend (Line)
            new Chart(document.getElementById('chartMonthlyTrend'), {
                type: 'line',
                data: {
                    labels: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Net Balance',
                        data: [5, 8, 12, 11, 15, 24],
                        borderColor: '#10b981',
                        borderWidth: 3,
                        tension: 0.3
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // 5. Budget Progress (Horizontal Bar)
            new Chart(document.getElementById('chartBudgetProgress'), {
                type: 'bar',
                data: {
                    labels: ['Makan', 'Otomotif', 'Kesehatan'],
                    datasets: [{
                        label: 'Usage (%)',
                        data: [75, 45, 20],
                        backgroundColor: ['#f43f5e', '#f59e0b', '#10b981'],
                        borderRadius: 6
                    }]
                },
                options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, scales: { x: { max: 100 } }, plugins: { legend: { display: false } } }
            });

            // 6. Saving Progress (Polar Area)
            new Chart(document.getElementById('chartSavingProgress'), {
                type: 'polarArea',
                data: {
                    labels: ['Liburan', 'Motor', 'Darurat'],
                    datasets: [{
                        data: [60, 40, 85],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b'],
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right' } } }
            });
        });
    </script>
</x-app-layout>
