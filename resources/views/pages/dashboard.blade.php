<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Dashboard" pageDescription="Welcome back, {{ $currentUser['name'] }}. Here's what's happening today.">

    @php $breadcrumbs = [['label' => 'Dashboard']]; @endphp

    {{-- Role-based welcome alert --}}
    @if($currentRole === 'viewer')
        <x-alert type="info" title="Read-Only Access" message="You are viewing the dashboard in read-only mode. Contact an admin to request additional permissions." class="mb-6" />
    @endif

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5 mb-8">
        @foreach($kpiCards as $index => $kpi)
            <div class="stagger-{{ $index + 1 }}">
                <x-kpi-card :title="$kpi['title']" :value="$kpi['value']" :change="$kpi['change']" :trend="$kpi['trend']" :icon="$kpi['icon']" :color="$kpi['color']" :description="$kpi['description']" />
            </div>
        @endforeach
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5 mb-8">
        {{-- Revenue Chart --}}
        <div class="lg:col-span-2">
            <x-card>
                <x-slot:header>
                    <div>
                        <h3 class="font-semibold" style="color: var(--text-primary);">Revenue Overview</h3>
                        <p class="text-xs mt-0.5" style="color: var(--text-tertiary);">Monthly revenue for the current year</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="btn btn-ghost btn-sm text-xs">Week</button>
                        <button class="btn btn-primary btn-sm text-xs">Month</button>
                        <button class="btn btn-ghost btn-sm text-xs">Year</button>
                    </div>
                </x-slot:header>
                <div class="h-64 sm:h-72">
                    <canvas id="revenueChart"></canvas>
                </div>
            </x-card>
        </div>

        {{-- User Stats Chart --}}
        <div>
            <x-card>
                <x-slot:header>
                    <div>
                        <h3 class="font-semibold" style="color: var(--text-primary);">User Distribution</h3>
                        <p class="text-xs mt-0.5" style="color: var(--text-tertiary);">By role category</p>
                    </div>
                </x-slot:header>
                <div class="h-56">
                    <canvas id="userDistChart"></canvas>
                </div>
                <div class="mt-4 space-y-2">
                    @php
                        $distData = [
                            ['label' => 'Admin', 'value' => 11, 'color' => '#6366f1'],
                            ['label' => 'Manager', 'value' => 24, 'color' => '#d946ef'],
                            ['label' => 'Staff', 'value' => 156, 'color' => '#10b981'],
                            ['label' => 'Viewer', 'value' => 57, 'color' => '#94a3b8'],
                        ];
                    @endphp
                    @foreach($distData as $item)
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" style="background: {{ $item['color'] }};"></span>
                                <span style="color: var(--text-secondary);">{{ $item['label'] }}</span>
                            </div>
                            <span class="font-medium" style="color: var(--text-primary);">{{ $item['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>

    {{-- Quick Actions + Recent Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5 mb-8">
        {{-- Recent Activity --}}
        <div class="lg:col-span-2">
            <x-card>
                <x-slot:header>
                    <h3 class="font-semibold" style="color: var(--text-primary);">Recent Activity</h3>
                    <a href="{{ route('activity-log') }}?role={{ $currentRole }}" class="text-sm font-medium" style="color: var(--color-brand-500);">View all</a>
                </x-slot:header>
                <div class="space-y-1">
                    @foreach($recentActivities as $activity)
                        <div class="flex items-start gap-3 p-3 rounded-lg transition-colors hover:bg-[var(--surface-secondary)]">
                            <x-avatar :initials="$activity['initials']" size="sm" />
                            <div class="flex-1 min-w-0">
                                <p class="text-sm" style="color: var(--text-primary);">
                                    <span class="font-medium">{{ $activity['user'] }}</span>
                                    <span style="color: var(--text-secondary);">{{ $activity['action'] }}</span>
                                    <span class="font-medium">{{ $activity['target'] }}</span>
                                </p>
                                <p class="text-xs mt-0.5" style="color: var(--text-tertiary);">{{ $activity['time'] }}</p>
                            </div>
                            @php
                                $typeColors = ['create' => 'success', 'update' => 'primary', 'delete' => 'danger', 'export' => 'accent', 'system' => 'neutral'];
                            @endphp
                            <x-badge :variant="$typeColors[$activity['type']] ?? 'neutral'">{{ ucfirst($activity['type']) }}</x-badge>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>

        {{-- Quick Actions --}}
        <div>
            <x-card>
                <x-slot:header>
                    <h3 class="font-semibold" style="color: var(--text-primary);">Quick Actions</h3>
                </x-slot:header>
                <div class="space-y-2">
                    @if(in_array($currentRole, ['superadmin', 'admin']))
                        <button class="w-full flex items-center gap-3 p-3 rounded-lg border transition-all hover:shadow-md hover:-translate-y-0.5" style="border-color: var(--border-primary); background: var(--surface-primary);" onclick="showToast('info', 'Action', 'Create user dialog would open here')">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: rgba(99,102,241,0.1);">
                                <svg class="w-5 h-5" style="color: var(--color-brand-500);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" /></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-medium" style="color: var(--text-primary);">Add New User</p>
                                <p class="text-xs" style="color: var(--text-tertiary);">Create a new account</p>
                            </div>
                        </button>
                    @endif
                    <button class="w-full flex items-center gap-3 p-3 rounded-lg border transition-all hover:shadow-md hover:-translate-y-0.5" style="border-color: var(--border-primary); background: var(--surface-primary);" onclick="showToast('success', 'Export', 'Report generation started')">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: rgba(16,185,129,0.1);">
                            <svg class="w-5 h-5" style="color: var(--color-success-500);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium" style="color: var(--text-primary);">Export Report</p>
                            <p class="text-xs" style="color: var(--text-tertiary);">Download analytics data</p>
                        </div>
                    </button>
                    @if(in_array($currentRole, ['superadmin', 'admin', 'manager']))
                        <button class="w-full flex items-center gap-3 p-3 rounded-lg border transition-all hover:shadow-md hover:-translate-y-0.5" style="border-color: var(--border-primary); background: var(--surface-primary);" onclick="showToast('info', 'Schedule', 'Scheduler would open here')">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: rgba(245,158,11,0.1);">
                                <svg class="w-5 h-5" style="color: var(--color-warning-500);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-medium" style="color: var(--text-primary);">Schedule Task</p>
                                <p class="text-xs" style="color: var(--text-tertiary);">Create automated task</p>
                            </div>
                        </button>
                    @endif
                    <button class="w-full flex items-center gap-3 p-3 rounded-lg border transition-all hover:shadow-md hover:-translate-y-0.5" style="border-color: var(--border-primary); background: var(--surface-primary);">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: rgba(217,70,239,0.1);">
                            <svg class="w-5 h-5" style="color: var(--color-accent-500);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium" style="color: var(--text-primary);">Help Center</p>
                            <p class="text-xs" style="color: var(--text-tertiary);">Browse documentation</p>
                        </div>
                    </button>
                </div>
            </x-card>
        </div>
    </div>

    {{-- Summary Table --}}
    @if(in_array($currentRole, ['superadmin', 'admin', 'manager', 'staff']))
        <x-card>
            <x-slot:header>
                <h3 class="font-semibold" style="color: var(--text-primary);">Recent Transactions</h3>
                <x-button variant="secondary" size="sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                    Export
                </x-button>
            </x-slot:header>
            <div class="table-responsive -mx-5 sm:-mx-6">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            @if(in_array($currentRole, ['superadmin', 'admin']))
                                <th class="text-right">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($summaryTable as $row)
                            <tr>
                                <td class="font-mono text-xs font-medium" style="color: var(--color-brand-500);">{{ $row['id'] }}</td>
                                <td class="font-medium">{{ $row['customer'] }}</td>
                                <td class="font-semibold">{{ $row['amount'] }}</td>
                                <td>
                                    @php
                                        $statusBadge = ['completed' => 'success', 'processing' => 'primary', 'pending' => 'warning', 'failed' => 'danger'];
                                    @endphp
                                    <x-badge :variant="$statusBadge[$row['status']] ?? 'neutral'" :dot="true">{{ ucfirst($row['status']) }}</x-badge>
                                </td>
                                <td style="color: var(--text-secondary);">{{ $row['date'] }}</td>
                                @if(in_array($currentRole, ['superadmin', 'admin']))
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button class="btn btn-ghost btn-icon btn-sm" onclick="showToast('info', 'View', 'Transaction details would open')">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            </button>
                                            <button class="btn btn-ghost btn-icon btn-sm" onclick="showToast('info', 'Edit', 'Edit dialog would open')">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    @endif

    {{-- Chart.js Init --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revCtx = document.getElementById('revenueChart');
            if (revCtx) {
                const isDark = document.documentElement.classList.contains('dark');
                const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
                const textColor = isDark ? '#94a3b8' : '#64748b';

                new Chart(revCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Revenue',
                            data: [42000, 48000, 45000, 52000, 49000, 58000, 63000, 59000, 67000, 72000, 78000, 84254],
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99, 102, 241, 0.08)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#6366f1',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                        }, {
                            label: 'Expenses',
                            data: [28000, 32000, 30000, 35000, 33000, 38000, 42000, 39000, 44000, 47000, 50000, 53000],
                            borderColor: '#d946ef',
                            backgroundColor: 'rgba(217, 70, 239, 0.05)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            borderDash: [5, 5],
                            pointRadius: 0,
                            pointHoverRadius: 5,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: true, position: 'top', labels: { usePointStyle: true, padding: 20, color: textColor, font: { size: 12, family: 'Inter' } } } },
                        scales: {
                            x: { grid: { display: false }, ticks: { color: textColor, font: { size: 11, family: 'Inter' } } },
                            y: { grid: { color: gridColor }, ticks: { color: textColor, font: { size: 11, family: 'Inter' }, callback: v => '$' + (v/1000) + 'K' }, border: { display: false } }
                        },
                        interaction: { mode: 'index', intersect: false }
                    }
                });
            }

            // User Distribution Doughnut
            const distCtx = document.getElementById('userDistChart');
            if (distCtx) {
                new Chart(distCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Admin', 'Manager', 'Staff', 'Viewer'],
                        datasets: [{ data: [11, 24, 156, 57], backgroundColor: ['#6366f1', '#d946ef', '#10b981', '#94a3b8'], borderWidth: 0, spacing: 2 }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: { legend: { display: false } }
                    }
                });
            }
        });
    </script>

</x-layouts.app>
