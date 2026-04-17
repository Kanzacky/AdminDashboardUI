@props(['menu', 'currentRoute', 'currentRole', 'roleInfo'])

<aside class="sidebar flex flex-col" id="sidebar">
    {{-- Brand Header --}}
    <div class="flex items-center gap-3 px-6 h-16 border-b border-white/10 flex-shrink-0">
        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, var(--color-brand-500), var(--color-accent-500));">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
            </svg>
        </div>
        <div class="sidebar-label overflow-hidden">
            <span class="text-white font-bold text-lg tracking-tight">TeloPanel</span>
            <div class="flex items-center gap-1.5 mt-0.5">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span class="text-xs text-white/50">v2.4.0</span>
            </div>
        </div>
    </div>

    {{-- Role Badge --}}
    <div class="px-4 py-3 sidebar-label">
        <div class="flex items-center gap-2 px-3 py-2 rounded-lg" style="background: rgba(255,255,255,0.06);">
            <div class="w-7 h-7 rounded-md flex items-center justify-center text-xs font-bold" style="background: rgba(255,255,255,0.12); color: white;">
                {{ strtoupper(substr($roleInfo['label'], 0, 2)) }}
            </div>
            <div class="overflow-hidden">
                <div class="text-xs font-semibold text-white truncate">{{ $roleInfo['label'] }}</div>
                <div class="text-[10px] text-white/40">Current Role</div>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 py-2 overflow-y-auto">
        @foreach($menu as $group)
            <div class="mb-2 sidebar-group-container">
                <div class="sidebar-group-label px-6 py-2 flex items-center justify-between cursor-pointer group" onclick="toggleSidebarGroup(this)" title="Toggle Group">
                    <span class="text-[10px] font-semibold uppercase tracking-widest text-white/40 group-hover:text-white/70 transition-colors">{{ $group['group'] }}</span>
                    <svg class="w-3 h-3 text-white/30 group-hover:text-white/60 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
                <div class="sidebar-group-items transition-all duration-300">
                @foreach($group['items'] as $item)
                    @php
                        $isActive = $currentRoute === $item['route'];
                        $hasChildren = !empty($item['children']);
                        $isChildActive = false;
                        if ($hasChildren) {
                            foreach ($item['children'] as $child) {
                                if ($currentRoute === $child['route']) {
                                    $isChildActive = true;
                                    $isActive = true;
                                }
                            }
                        }
                    @endphp

                    @if($hasChildren)
                        <div class="sidebar-menu-group">
                            <a href="{{ route($item['route']) }}?role={{ $currentRole }}"
                               class="sidebar-nav-item {{ $isActive ? 'active' : '' }}"
                               onclick="event.preventDefault(); toggleSubmenu(this)">
                                <x-icon :name="$item['icon']" class="w-5 h-5 flex-shrink-0 sidebar-nav-icon" />
                                <span class="sidebar-label flex-1 truncate">{{ $item['name'] }}</span>
                                @if(isset($item['badge']))
                                    <span class="sidebar-badge text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-white/15 text-white/80">{{ $item['badge'] }}</span>
                                @endif
                                <svg class="w-4 h-4 transition-transform duration-200 sidebar-chevron {{ $isActive ? 'rotate-90' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                            <div class="sidebar-submenu {{ $isActive ? '' : 'hidden' }}">
                                @foreach($item['children'] as $child)
                                    <a href="{{ route($child['route']) }}?role={{ $currentRole }}"
                                       class="sidebar-nav-item {{ $currentRoute === $child['route'] ? 'active' : '' }}">
                                        <span class="sidebar-label truncate">{{ $child['name'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route($item['route']) }}?role={{ $currentRole }}"
                           class="sidebar-nav-item {{ $isActive ? 'active' : '' }}">
                            <x-icon :name="$item['icon']" class="w-5 h-5 flex-shrink-0 sidebar-nav-icon" />
                            <span class="sidebar-label flex-1 truncate">{{ $item['name'] }}</span>
                            @if(isset($item['badge']))
                                <span class="sidebar-badge text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-white/15 text-white/80">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    @endif
                @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    {{-- Sidebar Footer (Links/Copyright) --}}
    <div class="px-6 py-4 border-t border-white/10 sidebar-label mt-auto">
        <div class="flex flex-col gap-1.5">
            <a href="#" class="text-xs text-white/60 hover:text-white transition-colors">Documentation</a>
            <a href="#" class="text-xs text-white/60 hover:text-white transition-colors">Terms of Service</a>
            <div class="text-[10px] text-white/30 mt-2">
                &copy; {{ date('Y') }} TeloPanel.<br>
                All rights reserved.
            </div>
        </div>
    </div>
</aside>
