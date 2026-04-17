<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Activity Log" pageDescription="Monitor all user actions and system events across the platform.">

    @php $breadcrumbs = [['label' => 'Monitoring', 'url' => '#'], ['label' => 'Activity Log']]; @endphp

    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <x-search-filter placeholder="Search activity..." :filters="[
            ['label' => 'All Actions', 'options' => ['created' => 'Created', 'updated' => 'Updated', 'deleted' => 'Deleted', 'login' => 'Login', 'exported' => 'Exported']],
            ['label' => 'All Categories', 'options' => ['user' => 'User', 'role' => 'Role', 'system' => 'System', 'auth' => 'Auth', 'content' => 'Content']],
        ]" />
        <x-date-range />
    </div>

    {{-- Activity Table --}}
    <x-card padding="p-0">
        <div class="table-responsive border-0" style="border: none;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Target</th>
                        <th>Category</th>
                        <th>IP Address</th>
                        <th>Timestamp</th>
                        <th class="text-right">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                        <tr>
                            <td>
                                <div class="flex items-center gap-2">
                                    <x-avatar :initials="$activity['initials']" size="sm" />
                                    <span class="font-medium text-sm">{{ $activity['user'] }}</span>
                                </div>
                            </td>
                            <td>
                                @php
                                    $actionBadges = ['Created' => 'success', 'Updated' => 'primary', 'Modified' => 'primary', 'Deleted' => 'danger', 'Exported' => 'accent', 'Executed' => 'warning', 'Login' => 'neutral', 'Uploaded' => 'success'];
                                @endphp
                                <x-badge :variant="$actionBadges[$activity['action']] ?? 'neutral'">{{ $activity['action'] }}</x-badge>
                            </td>
                            <td class="text-sm max-w-xs truncate" style="color: var(--text-secondary);">{{ $activity['target'] }}</td>
                            <td>
                                <span class="text-xs font-mono px-2 py-0.5 rounded" style="background: var(--surface-tertiary); color: var(--text-secondary);">{{ $activity['category'] }}</span>
                            </td>
                            <td class="text-xs font-mono" style="color: var(--text-tertiary);">{{ $activity['ip'] }}</td>
                            <td class="text-xs whitespace-nowrap" style="color: var(--text-tertiary);">{{ $activity['timestamp'] }}</td>
                            <td class="text-right">
                                <button class="btn btn-ghost btn-icon btn-sm" onclick="showToast('info', 'Details', '{{ $activity['details'] }}')">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t" style="border-color: var(--border-primary);">
            <x-pagination :currentPage="1" :totalPages="12" />
        </div>
    </x-card>

</x-layouts.app>
