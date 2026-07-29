@props([
    'id',
    'type' => 'bar', // bar, line, doughnut, pie
    'data' => [],
    'options' => [],
    'height' => '280',
])

<div class="relative w-full" style="height: {{ $height }}px;">
    <canvas id="{{ $id }}"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('{{ $id }}');
        if (ctx) {
            new Chart(ctx, {
                type: '{{ $type }}',
                data: @json($data),
                options: Object.assign({
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? '#94a3b8' : '#475569',
                                font: { family: 'Outfit, Inter, sans-serif', size: 12 }
                            }
                        }
                    },
                    scales: '{{ $type }}' === 'doughnut' || '{{ $type }}' === 'pie' ? {} : {
                        x: {
                            ticks: { color: document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b' },
                            grid: { color: document.documentElement.classList.contains('dark') ? 'rgba(51, 65, 85, 0.4)' : 'rgba(226, 232, 240, 0.8)' }
                        },
                        y: {
                            ticks: { color: document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b' },
                            grid: { color: document.documentElement.classList.contains('dark') ? 'rgba(51, 65, 85, 0.4)' : 'rgba(226, 232, 240, 0.8)' }
                        }
                    }
                }, @json($options))
            });
        }
    });
</script>
