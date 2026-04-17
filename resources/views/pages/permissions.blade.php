<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Permissions" pageDescription="View and manage granular permissions across all roles.">

    @php $breadcrumbs = [['label' => 'Management', 'url' => '#'], ['label' => 'Roles', 'url' => route('roles').'?role='.$currentRole], ['label' => 'Permissions']]; @endphp

    @if($currentRole !== 'superadmin')
        <x-alert type="warning" title="Limited Access" message="Only Super Admins can modify permission settings. You are viewing in read-only mode." class="mb-6" />
    @endif

    <div class="space-y-6">
        @foreach($permissionGroups as $groupName => $permissions)
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: rgba(99,102,241,0.1);">
                            <svg class="w-5 h-5" style="color: var(--color-brand-500);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold" style="color: var(--text-primary);">{{ $groupName }}</h3>
                            <p class="text-xs" style="color: var(--text-tertiary);">{{ count($permissions) }} permissions</p>
                        </div>
                    </div>
                    <x-badge variant="primary">{{ count($permissions) }}</x-badge>
                </x-slot:header>

                <div class="space-y-4">
                    @foreach($permissions as $perm)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3 rounded-lg border" style="border-color: var(--border-secondary);">
                            <div>
                                <div class="flex items-center gap-2">
                                    <code class="text-xs font-mono px-2 py-0.5 rounded" style="background: var(--surface-tertiary); color: var(--color-brand-500);">{{ $perm['name'] }}</code>
                                </div>
                                <p class="text-sm mt-1" style="color: var(--text-secondary);">{{ $perm['description'] }}</p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                @foreach(['Super Admin', 'Admin', 'Manager', 'Staff', 'Viewer'] as $roleName)
                                    @php
                                        $rolePerms = $rolePermissions[$roleName] ?? [];
                                        $hasPermission = false;
                                        foreach ($rolePerms as $group => $perms) {
                                            if (is_array($perms) && in_array($perm['name'], $perms)) {
                                                $hasPermission = true;
                                                break;
                                            }
                                        }
                                        $roleColors = ['Super Admin' => '#ef4444', 'Admin' => '#6366f1', 'Manager' => '#d946ef', 'Staff' => '#10b981', 'Viewer' => '#94a3b8'];
                                    @endphp
                                    <x-tooltip :text="$roleName . ': ' . ($hasPermission ? 'Granted' : 'Denied')">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold border-2 {{ $hasPermission ? 'text-white' : '' }}"
                                             style="{{ $hasPermission ? 'background:' . $roleColors[$roleName] . '; border-color:' . $roleColors[$roleName] : 'border-color: var(--border-primary); color: var(--text-tertiary);' }}">
                                            {{ substr($roleName, 0, 1) }}
                                        </div>
                                    </x-tooltip>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>
        @endforeach
    </div>

</x-layouts.app>
