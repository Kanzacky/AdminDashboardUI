@props(['currentUser', 'notifications', 'roleInfo', 'currentRole'])

<header class="topbar">
    {{-- Sidebar Toggle --}}
    <button class="btn btn-ghost btn-icon mr-2 sm:mr-3" onclick="if(window.innerWidth >= 1024) { toggleSidebar() } else { toggleMobileSidebar() }" id="main-menu-btn">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    {{-- Search Bar --}}
    <div class="hidden sm:flex items-center flex-1 max-w-md relative">
        <svg class="w-4 h-4 absolute left-3 pointer-events-none" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
        <input type="text"
               placeholder="Search anything... (⌘K)"
               class="form-input pl-10 pr-4 py-2 text-sm"
               style="background-color: var(--surface-secondary); border-color: var(--border-secondary);"
               id="global-search"
               onclick="openSearchModal()">
    </div>

    <div class="flex-1 sm:hidden"></div>

    {{-- Right Side Actions --}}
    <div class="flex items-center gap-1 sm:gap-2 ml-4">
        {{-- Mobile Search --}}
        <button class="sm:hidden btn btn-ghost btn-icon btn-sm" onclick="openSearchModal()">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </button>

        {{-- Dark Mode Toggle --}}
        <button class="btn btn-ghost btn-icon btn-sm" onclick="toggleTheme()" id="theme-toggle" title="Toggle dark mode">
            <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            </svg>
            <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
            </svg>
        </button>

        {{-- Notifications --}}
        <div class="relative" id="notification-dropdown-container">
            <button class="btn btn-ghost btn-icon btn-sm relative" onclick="toggleDropdown('notification-dropdown')" id="notification-btn">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                @php $unreadCount = count(array_filter($notifications, fn($n) => !$n['read'])); @endphp
                @if($unreadCount > 0)
                    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 text-[10px] font-bold rounded-full flex items-center justify-center text-white" style="background: var(--color-danger-500);">{{ $unreadCount }}</span>
                @endif
            </button>

            <div class="dropdown-menu w-80 sm:w-96 p-0" id="notification-dropdown">
                <div class="flex items-center justify-between p-4 border-b" style="border-color: var(--border-primary);">
                    <h3 class="font-semibold text-sm" style="color: var(--text-primary);">Notifications</h3>
                    <a href="{{ route('notifications') }}?role={{ $currentRole }}" class="text-xs font-medium" style="color: var(--color-brand-500);">View all</a>
                </div>
                <div class="max-h-80 overflow-y-auto">
                    @foreach($notifications as $notif)
                        <div class="flex gap-3 p-4 border-b transition-colors hover:bg-[var(--surface-secondary)] {{ !$notif['read'] ? '' : 'opacity-60' }}" style="border-color: var(--border-secondary);">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                                {{ $notif['type'] === 'warning' ? 'bg-amber-100 text-amber-600' : '' }}
                                {{ $notif['type'] === 'success' ? 'bg-emerald-100 text-emerald-600' : '' }}
                                {{ $notif['type'] === 'danger' ? 'bg-red-100 text-red-600' : '' }}
                                {{ $notif['type'] === 'info' ? 'bg-blue-100 text-blue-600' : '' }}
                            ">
                                @if($notif['type'] === 'warning')
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                                @elseif($notif['type'] === 'success')
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @elseif($notif['type'] === 'danger')
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-medium truncate" style="color: var(--text-primary);">{{ $notif['title'] }}</p>
                                    @if(!$notif['read'])
                                        <span class="w-2 h-2 rounded-full flex-shrink-0" style="background: var(--color-brand-500);"></span>
                                    @endif
                                </div>
                                <p class="text-xs mt-0.5 line-clamp-2" style="color: var(--text-secondary);">{{ $notif['message'] }}</p>
                                <p class="text-[11px] mt-1" style="color: var(--text-tertiary);">{{ $notif['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="hidden sm:block w-px h-6 mx-1" style="background: var(--border-primary);"></div>

        {{-- Profile Dropdown --}}
        <div class="relative" id="profile-dropdown-container">
            <button class="flex items-center gap-2 px-2 py-1.5 rounded-lg transition-colors hover:bg-[var(--surface-secondary)]"
                    onclick="toggleDropdown('profile-dropdown')" id="profile-btn">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-xs font-bold text-white">
                    {{ $currentUser['initials'] }}
                </div>
                <div class="hidden sm:block text-left">
                    <div class="text-sm font-medium leading-tight" style="color: var(--text-primary);">{{ $currentUser['name'] }}</div>
                    <div class="text-[11px]" style="color: var(--text-tertiary);">{{ $currentUser['role'] }}</div>
                </div>
                <svg class="hidden sm:block w-4 h-4" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <div class="dropdown-menu w-56" id="profile-dropdown">
                <div class="px-3 py-2 border-b" style="border-color: var(--border-primary);">
                    <p class="text-sm font-medium" style="color: var(--text-primary);">{{ $currentUser['name'] }}</p>
                    <p class="text-xs" style="color: var(--text-tertiary);">{{ $currentUser['email'] }}</p>
                </div>
                <div class="py-1">
                    <a href="{{ route('profile') }}?role={{ $currentRole }}" class="dropdown-item">
                        <svg class="w-4 h-4" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        My Profile
                    </a>
                    <a href="{{ route('settings') }}?role={{ $currentRole }}" class="dropdown-item">
                        <svg class="w-4 h-4" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Settings
                    </a>
                    <a href="{{ route('help') }}?role={{ $currentRole }}" class="dropdown-item">
                        <svg class="w-4 h-4" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
                        Help & Support
                    </a>
                </div>
                <div class="border-t py-1" style="border-color: var(--border-primary);">
                    <a href="{{ route('login') }}" class="dropdown-item text-red-500">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                        Sign Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
