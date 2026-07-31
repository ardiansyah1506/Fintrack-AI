<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'FinTrack AI - Personal Finance Management' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Backdrop (Mobile) -->
        <div 
            x-show="sidebarOpen" 
            x-cloak
            x-on:click="sidebarOpen = false" 
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-xs lg:hidden transition-opacity"
        ></div>

        <!-- Sidebar Navigation -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200/80 flex flex-col transition-transform duration-300 lg:translate-x-0 lg:static lg:z-auto"
        >
            <!-- Logo Header -->
            <div class="h-20 px-6 flex items-center justify-between border-b border-slate-100">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 via-emerald-500 to-teal-500 flex items-center justify-center text-white shadow-md shadow-emerald-500/30">
                        <i class="fa-solid fa-leaf text-lg"></i>
                    </div>
                    <div>
                        <span class="font-bold text-lg tracking-tight bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-800 bg-clip-text text-transparent">FinTrack<span class="text-emerald-600">AI</span></span>
                        <span class="block text-[10px] font-semibold tracking-wider text-slate-400 uppercase">Control Center</span>
                    </div>
                </a>
                <button x-on:click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-chart-pie text-base w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('transactions.index') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('transactions.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-wallet text-base w-5 text-center"></i>
                    <span>Transactions</span>
                </a>

                <a href="{{ route('reports.index') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('reports.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-chart-column text-base w-5 text-center"></i>
                    <span>Reports</span>
                </a>
                
                <a href="{{ route('budgets.index') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('budgets.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-chart-line text-base w-5 text-center"></i>
                    <span>Budgets</span>
                </a>

                <a href="{{ route('saving-goals.index') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('saving-goals.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-bullseye text-base w-5 text-center"></i>
                    <span>Saving Goals</span>
                </a>

                <a href="{{ route('bills.index') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('bills.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-file-invoice-dollar text-base w-5 text-center"></i>
                    <span>Bills</span>
                </a>

                <a href="{{ route('reminders.index') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('reminders.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-bell text-base w-5 text-center"></i>
                    <span>Reminders</span>
                </a>

                <a href="{{ route('notifications.index') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('notifications.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-envelope text-base w-5 text-center"></i>
                    <span>Notifications</span>
                </a>

                <a href="{{ route('ai-center.index') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('ai-center.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-brain text-base w-5 text-center"></i>
                    <span>AI Center</span>
                </a>

                <a href="{{ route('telegram.config') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('telegram.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-brands fa-telegram text-base w-5 text-center"></i>
                    <span>Telegram Center</span>
                </a>

                <a href="{{ route('settings.index') }}" class="flex items-center gap-3.5 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('settings.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-sliders text-base w-5 text-center"></i>
                    <span>Settings</span>
                </a>
            </nav>

            <!-- Telegram / n8n Ready Indicator Badge -->
            <div class="p-4 mx-4 mb-4 rounded-2xl bg-gradient-to-br from-emerald-900/90 to-slate-900 text-white shadow-sm border border-emerald-700/40">
                <div class="flex items-center gap-2 mb-2">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-semibold text-emerald-200 uppercase tracking-wider">AI Control Center</span>
                </div>
                <p class="text-xs text-slate-300">N8n Engine & Laravel API siap melayani bot.</p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between gap-4 z-10">
                <div class="flex items-center gap-4">
                    <button x-on:click="sidebarOpen = true" type="button" class="lg:hidden p-2 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ $header ?? 'Dashboard' }}</h1>
                        @if(isset($breadcrumb))
                            <nav class="flex items-center gap-2 text-xs text-slate-400 mt-0.5">
                                {{ $breadcrumb }}
                            </nav>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('transactions.index', ['action' => 'create']) }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white shadow-md shadow-emerald-500/20 transition-all">
                        <i class="fa-solid fa-plus"></i>
                        <span>Catat Transaksi</span>
                    </a>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-8">
                @if (session('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif
                @if (session('error'))
                    <x-alert type="error" :message="session('error')" />
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>
