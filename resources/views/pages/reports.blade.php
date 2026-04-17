<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Reports" pageDescription="Generate, view, and download organizational reports.">

    @php $breadcrumbs = [['label' => 'Reports']]; @endphp

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <x-search-filter placeholder="Search reports..." :filters="[
            ['label' => 'All Types', 'options' => ['analytics' => 'Analytics', 'finance' => 'Finance', 'security' => 'Security', 'technical' => 'Technical', 'operations' => 'Operations']],
        ]" />
        @if(in_array($currentRole, ['superadmin', 'admin', 'manager']))
            <x-button variant="primary" size="sm" onclick="showToast('info', 'Generate', 'Report wizard would open here')">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Generate Report
            </x-button>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
        @foreach($reportsList as $report)
            <div class="card card-interactive p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(99,102,241,0.1);">
                        <svg class="w-5 h-5" style="color: var(--color-brand-500);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    </div>
                    <x-badge variant="neutral">{{ $report['format'] }}</x-badge>
                </div>
                <h3 class="font-semibold text-sm mb-1" style="color: var(--text-primary);">{{ $report['name'] }}</h3>
                <p class="text-xs mb-4 line-clamp-2" style="color: var(--text-secondary);">{{ $report['description'] }}</p>
                <div class="flex items-center justify-between text-xs" style="color: var(--text-tertiary);">
                    <span>{{ $report['lastGenerated'] }}</span>
                    <span>{{ $report['size'] }}</span>
                </div>
                <div class="flex items-center gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border-secondary);">
                    <x-button variant="secondary" size="sm" class="flex-1" onclick="showToast('info', 'Preview', 'Report preview would open')">Preview</x-button>
                    <x-button variant="primary" size="sm" class="flex-1" onclick="showToast('success', 'Download', 'Report download started')">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        Download
                    </x-button>
                </div>
            </div>
        @endforeach
    </div>

</x-layouts.app>
