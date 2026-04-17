<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Analytics" pageDescription="Track key metrics, user behavior, and system performance.">

    @php $breadcrumbs = [['label' => 'Analytics']]; @endphp

    {{-- Date Range --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <x-date-range />
        <x-button variant="secondary" size="sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
            Export
        </x-button>
    </div>

    {{-- Metric Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
        @foreach($metrics as $metric)
            <div class="card p-5">
                <p class="text-sm font-medium mb-1" style="color: var(--text-secondary);">{{ $metric['label'] }}</p>
                <p class="text-2xl font-bold" style="color: var(--text-primary);">{{ $metric['value'] }}</p>
                <div class="flex items-center gap-1 mt-2">
                    <span class="text-xs font-semibold px-1.5 py-0.5 rounded-full {{ $metric['trend'] === 'up' ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }}">{{ $metric['change'] }}</span>
                    <span class="text-xs" style="color: var(--text-tertiary);">vs last period</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <x-card>
            <x-slot:header>
                <h3 class="font-semibold" style="color: var(--text-primary);">Traffic Overview</h3>
            </x-slot:header>
            <div class="h-72"><canvas id="trafficChart"></canvas></div>
        </x-card>
        <x-card>
            <x-slot:header>
                <h3 class="font-semibold" style="color: var(--text-primary);">User Growth</h3>
            </x-slot:header>
            <div class="h-72"><canvas id="growthChart"></canvas></div>
        </x-card>
    </div>

    {{-- Top Pages --}}
    <x-card>
        <x-slot:header>
            <h3 class="font-semibold" style="color: var(--text-primary);">Top Pages</h3>
        </x-slot:header>
        <div class="overflow-x-auto -mx-5 sm:-mx-6">
            <table class="data-table">
                <thead><tr><th>Page</th><th>Views</th><th>Unique Visitors</th><th>Bounce Rate</th><th>Avg. Duration</th></tr></thead>
                <tbody>
                    @php $pages = [
                        ['/dashboard', '45,231', '12,847', '18.2%', '5m 12s'],
                        ['/users', '28,412', '8,234', '22.5%', '3m 44s'],
                        ['/analytics', '19,873', '6,129', '15.8%', '6m 28s'],
                        ['/reports', '15,209', '4,892', '28.1%', '4m 15s'],
                        ['/settings', '8,745', '3,201', '35.4%', '2m 33s'],
                    ]; @endphp
                    @foreach($pages as $page)
                        <tr>
                            <td class="font-mono text-sm" style="color: var(--color-brand-500);">{{ $page[0] }}</td>
                            <td class="font-medium">{{ $page[1] }}</td>
                            <td>{{ $page[2] }}</td>
                            <td>{{ $page[3] }}</td>
                            <td>{{ $page[4] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
            const textColor = isDark ? '#94a3b8' : '#64748b';
            const baseOpts = { responsive: true, maintainAspectRatio: false, plugins: { legend: { labels: { color: textColor, font: { family: 'Inter', size: 12 }, usePointStyle: true, padding: 16 } } }, scales: { x: { grid: { display: false }, ticks: { color: textColor, font: { family: 'Inter', size: 11 } } }, y: { grid: { color: gridColor }, ticks: { color: textColor, font: { family: 'Inter', size: 11 } }, border: { display: false } } } };

            new Chart(document.getElementById('trafficChart'), {
                type: 'bar', data: { labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], datasets: [{ label: 'Page Views', data: [4200,3800,5100,4800,5600,3200,2800], backgroundColor: '#6366f1', borderRadius: 6 }, { label: 'Sessions', data: [2100,1900,2500,2400,2800,1600,1400], backgroundColor: '#d946ef', borderRadius: 6 }] }, options: baseOpts
            });

            new Chart(document.getElementById('growthChart'), {
                type: 'line', data: { labels: ['W1','W2','W3','W4','W5','W6','W7','W8','W9','W10','W11','W12'], datasets: [{ label: 'New Users', data: [120,145,132,168,178,195,210,188,225,242,258,280], borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.08)', fill: true, tension: 0.4, pointRadius: 0 }, { label: 'Active Users', data: [980,1020,1050,1100,1080,1150,1200,1180,1250,1300,1350,1420], borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.05)', fill: true, tension: 0.4, pointRadius: 0 }] }, options: baseOpts
            });
        });
    </script>

</x-layouts.app>
