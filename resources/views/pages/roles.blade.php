<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Roles" pageDescription="Manage roles, permissions, and role hierarchy for your organization.">

    @php $breadcrumbs = [['label' => 'Management', 'url' => '#'], ['label' => 'Roles']]; @endphp

    {{-- Role Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5 mb-8">
        @foreach($roles as $role)
            @php
                $colors = ['danger' => '#ef4444', 'primary' => '#6366f1', 'accent' => '#d946ef', 'success' => '#10b981', 'neutral' => '#94a3b8'];
                $c = $colors[$role['color']] ?? '#6366f1';
            @endphp
            <div class="card card-interactive p-5 sm:p-6 animate-fade-in-up" style="opacity:0;animation-fill-mode:forwards;animation-delay:{{ $loop->index * 0.06 }}s;">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: {{ $c }}15; color: {{ $c }};">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold" style="color: var(--text-primary);">{{ $role['name'] }}</h3>
                            <span class="text-xs" style="color: var(--text-tertiary);">Level {{ $role['level'] }}</span>
                        </div>
                    </div>
                    @if($role['isSystem'])
                        <x-badge variant="neutral">System</x-badge>
                    @endif
                </div>
                <p class="text-sm mb-4 line-clamp-2" style="color: var(--text-secondary);">{{ $role['description'] }}</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            <span style="color: var(--text-secondary);">{{ $role['userCount'] }} users</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
                            <span style="color: var(--text-secondary);">{{ $role['permissionCount'] }} permissions</span>
                        </div>
                    </div>
                </div>
                <x-progress-bar :value="$role['permissionCount']" :max="48" class="mt-4" :showPercent="false" :label="''" />
            </div>
        @endforeach
    </div>

    {{-- Role Hierarchy --}}
    <x-card class="mb-8">
        <x-slot:header>
            <h3 class="font-semibold" style="color: var(--text-primary);">Role Hierarchy</h3>
            <x-badge variant="primary">{{ count($roles) }} roles</x-badge>
        </x-slot:header>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-2 sm:gap-0 py-4">
            @foreach($roles as $index => $role)
                @php $c = $colors[$role['color']] ?? '#6366f1'; @endphp
                <div class="flex items-center gap-2 sm:flex-col sm:gap-1 sm:text-center px-4 sm:px-6 py-3 rounded-xl transition-colors hover:bg-[var(--surface-secondary)]">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white text-sm flex-shrink-0" style="background: {{ $c }};">
                        {{ $role['level'] }}
                    </div>
                    <div class="sm:mt-2">
                        <p class="text-sm font-semibold" style="color: var(--text-primary);">{{ $role['name'] }}</p>
                        <p class="text-xs" style="color: var(--text-tertiary);">{{ $role['userCount'] }} users</p>
                    </div>
                </div>
                @if(!$loop->last)
                    <div class="hidden sm:flex items-center">
                        <svg class="w-6 h-6" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                    </div>
                @endif
            @endforeach
        </div>
    </x-card>

    {{-- Permission Matrix --}}
    <x-card>
        <x-slot:header>
            <h3 class="font-semibold" style="color: var(--text-primary);">Permission Matrix</h3>
            <p class="text-sm" style="color: var(--text-tertiary);">Role-based access control overview</p>
        </x-slot:header>
        <div class="overflow-x-auto -mx-5 sm:-mx-6">
            <table class="data-table min-w-[700px]">
                <thead>
                    <tr>
                        <th class="w-48">Permission</th>
                        @foreach($roles as $role)
                            <th class="text-center">{{ $role['name'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissionGroups as $group => $perms)
                        <tr>
                            <td colspan="{{ count($roles) + 1 }}" class="font-semibold text-xs uppercase tracking-wider" style="background: var(--surface-secondary); color: var(--text-secondary);">
                                {{ $group }}
                            </td>
                        </tr>
                        @foreach($perms as $perm)
                            <tr>
                                <td class="text-sm font-mono" style="color: var(--text-secondary);">{{ $perm }}</td>
                                @foreach($roles as $role)
                                    <td class="text-center">
                                        @if(in_array($perm, $permissionMatrix[$role['slug']] ?? []))
                                            <div class="inline-flex">
                                                <x-toggle :active="true" />
                                            </div>
                                        @else
                                            <div class="inline-flex">
                                                <x-toggle :active="false" />
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

</x-layouts.app>
