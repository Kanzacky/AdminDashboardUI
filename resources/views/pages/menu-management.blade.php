<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Menu Management" pageDescription="Configure sidebar navigation, menu ordering, and role-based menu access.">

    @php $breadcrumbs = [['label' => 'System', 'url' => '#'], ['label' => 'Menu Management']]; @endphp

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Menu List --}}
        <div class="xl:col-span-2">
            <x-card>
                <x-slot:header>
                    <h3 class="font-semibold" style="color: var(--text-primary);">Menu Items</h3>
                    <div class="flex gap-2">
                        <x-button variant="secondary" size="sm" onclick="showToast('info', 'Reorder', 'Drag items to reorder menu')">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                            Reorder
                        </x-button>
                        <x-button variant="primary" size="sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Add Menu
                        </x-button>
                    </div>
                </x-slot:header>

                <div class="space-y-2" id="menu-list">
                    @foreach($menuItems as $item)
                        <div class="border rounded-xl overflow-hidden transition-all {{ !$item['enabled'] ? 'opacity-50' : '' }}" style="border-color: var(--border-primary);">
                            <div class="flex items-center gap-3 p-4 cursor-move hover:bg-[var(--surface-secondary)] transition-colors">
                                {{-- Drag Handle --}}
                                <div class="flex flex-col gap-0.5 cursor-grab" style="color: var(--text-tertiary);">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" /></svg>
                                </div>

                                {{-- Icon --}}
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background: var(--surface-tertiary);">
                                    <x-icon :name="$item['icon']" class="w-5 h-5" style="color: var(--text-secondary);" />
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-sm" style="color: var(--text-primary);">{{ $item['name'] }}</span>
                                        @if(!$item['enabled'])
                                            <x-badge variant="neutral">Disabled</x-badge>
                                        @endif
                                        @if(count($item['children'] ?? []) > 0)
                                            <x-badge variant="primary">{{ count($item['children']) }} sub-items</x-badge>
                                        @endif
                                    </div>
                                    <p class="text-xs mt-0.5" style="color: var(--text-tertiary);">{{ $item['route'] }}</p>
                                </div>

                                {{-- Role Badges --}}
                                <div class="hidden sm:flex items-center gap-1 flex-shrink-0">
                                    @foreach($item['roles'] ?? [] as $r)
                                        @php
                                            $roleColors = ['superadmin' => '#ef4444', 'admin' => '#6366f1', 'manager' => '#d946ef', 'staff' => '#10b981', 'viewer' => '#94a3b8'];
                                        @endphp
                                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-[8px] font-bold text-white" style="background: {{ $roleColors[$r] ?? '#94a3b8' }};" title="{{ ucfirst($r) }}">
                                            {{ strtoupper(substr($r, 0, 1)) }}
                                        </span>
                                    @endforeach
                                </div>

                                {{-- Toggle --}}
                                <x-toggle :active="$item['enabled']" />

                                {{-- Actions --}}
                                <div class="relative" id="menu-action-{{ $item['id'] }}-container">
                                    <button class="btn btn-ghost btn-icon btn-sm" onclick="toggleDropdown('menu-action-{{ $item['id'] }}')">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" /></svg>
                                    </button>
                                    <div class="dropdown-menu" id="menu-action-{{ $item['id'] }}">
                                        <a class="dropdown-item" onclick="closeDropdown('menu-action-{{ $item['id'] }}')">Edit</a>
                                        <a class="dropdown-item" onclick="closeDropdown('menu-action-{{ $item['id'] }}')">Duplicate</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-red-500" onclick="closeDropdown('menu-action-{{ $item['id'] }}')">Delete</a>
                                    </div>
                                </div>
                            </div>

                            {{-- Children --}}
                            @if(count($item['children'] ?? []) > 0)
                                <div class="border-t pl-16 pr-4 py-2" style="border-color: var(--border-secondary); background: var(--surface-secondary);">
                                    @foreach($item['children'] as $child)
                                        <div class="flex items-center gap-3 py-2.5 px-3 rounded-lg hover:bg-[var(--surface-primary)] transition-colors">
                                            <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" /></svg>
                                            <span class="text-sm" style="color: var(--text-primary);">{{ $child['name'] }}</span>
                                            <span class="text-xs" style="color: var(--text-tertiary);">{{ $child['route'] }}</span>
                                            <div class="ml-auto">
                                                <x-toggle :active="$child['enabled']" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>

        {{-- Preview Panel --}}
        <div>
            <x-card class="sticky top-20">
                <x-slot:header>
                    <h3 class="font-semibold" style="color: var(--text-primary);">Menu Preview</h3>
                    <select class="form-input text-sm w-32" id="preview-role-select" onchange="showToast('info', 'Preview', 'Showing menu for ' + this.value)">
                        <option value="superadmin">Super Admin</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="staff">Staff</option>
                        <option value="viewer">Viewer</option>
                    </select>
                </x-slot:header>

                <div class="rounded-xl overflow-hidden" style="background: var(--surface-sidebar);">
                    <div class="p-4 space-y-1">
                        @foreach($menuItems as $item)
                            @if($item['enabled'])
                                <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ $loop->first ? 'bg-white/10' : '' }}" style="color: rgba(255,255,255,0.7);">
                                    <x-icon :name="$item['icon']" class="w-4 h-4" />
                                    <span class="text-sm">{{ $item['name'] }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 p-3 rounded-lg" style="background: rgba(99,102,241,0.08);">
                    <p class="text-xs font-medium" style="color: var(--color-brand-500);">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                        Switch roles using the floating button to see how menu changes per role.
                    </p>
                </div>
            </x-card>
        </div>
    </div>

</x-layouts.app>
