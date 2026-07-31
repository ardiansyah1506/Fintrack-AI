<x-app-layout title="AI Insights - Control Center">
    <x-slot name="header">AI Insights Analytics</x-slot>
    <div class="space-y-6 text-slate-800 font-sans">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div>
                <h2 class="font-bold text-xl text-slate-800">Insight \& Rekomendasi Pintar</h2>
                <p class="text-xs text-slate-400 mt-1">Data dihasilkan secara otomatis menggunakan model Gemini via n8n.</p>
            </div>
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl shadow-sm text-sm font-semibold transition">
                <i class="fa-solid fa-wand-magic-sparkles mr-2"></i> Generate Now
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($insights as $insight)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative hover:shadow-md transition flex flex-col gap-4">
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex justify-center items-center shrink-0">
                        <i class="fa-solid fa-robot text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-slate-800">{{ $insight->title }}</h3>
                        <p class="text-[11px] text-slate-400 mt-1">{{ date('d M Y, H:i', strtotime($insight->generated_at)) }} • Tipe: {{ ucfirst($insight->type) }}</p>
                    </div>
                </div>
                <div class="bg-slate-50 p-5 rounded-2xl text-sm text-slate-600 leading-relaxed border border-slate-100/60 grow">
                    {{ $insight->content }}
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white p-8 rounded-3xl text-center shadow-sm text-slate-400">
                AI belum men-generate insight apapun.
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
