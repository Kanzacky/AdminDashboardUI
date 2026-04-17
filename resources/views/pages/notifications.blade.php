<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Notifications" pageDescription="Stay informed with system alerts, updates, and important events.">

    @php
        $breadcrumbs = [['label' => 'Notifications']];
        $unread = array_filter($allNotifications, fn($n) => !$n['read']);
    @endphp

    {{-- Actions Bar --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <x-badge variant="primary">{{ count($unread) }} unread</x-badge>
        </div>
        <div class="flex items-center gap-2">
            <x-button variant="ghost" size="sm" onclick="showToast('success', 'Done', 'All notifications marked as read')">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Mark all read
            </x-button>
            <x-button variant="ghost" size="sm" onclick="showToast('info', 'Settings', 'Notification preferences would open')">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /></svg>
                Settings
            </x-button>
        </div>
    </div>

    {{-- Notification List --}}
    <div class="space-y-3">
        @foreach($allNotifications as $notif)
            @php
                $typeStyles = [
                    'info' => ['bg' => 'rgba(99,102,241,0.08)', 'color' => 'var(--color-brand-500)', 'iconBg' => 'bg-blue-100 text-blue-600'],
                    'warning' => ['bg' => 'rgba(245,158,11,0.08)', 'color' => 'var(--color-warning-500)', 'iconBg' => 'bg-amber-100 text-amber-600'],
                    'success' => ['bg' => 'rgba(16,185,129,0.08)', 'color' => 'var(--color-success-500)', 'iconBg' => 'bg-emerald-100 text-emerald-600'],
                    'danger' => ['bg' => 'rgba(239,68,68,0.08)', 'color' => 'var(--color-danger-500)', 'iconBg' => 'bg-red-100 text-red-600'],
                ];
                $style = $typeStyles[$notif['type']] ?? $typeStyles['info'];
            @endphp
            <div class="card p-4 sm:p-5 flex gap-4 transition-all {{ !$notif['read'] ? 'border-l-3' : 'opacity-70' }}" style="{{ !$notif['read'] ? 'border-left: 3px solid ' . $style['color'] : '' }}">
                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $style['iconBg'] }}">
                    @if($notif['type'] === 'warning')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                    @elseif($notif['type'] === 'success')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @elseif($notif['type'] === 'danger')
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h4 class="text-sm font-semibold" style="color: var(--text-primary);">{{ $notif['title'] }}</h4>
                            <p class="text-sm mt-1" style="color: var(--text-secondary);">{{ $notif['message'] }}</p>
                        </div>
                        @if(!$notif['read'])
                            <span class="w-2.5 h-2.5 rounded-full flex-shrink-0 mt-1.5" style="background: var(--color-brand-500);"></span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs" style="color: var(--text-tertiary);">{{ $notif['time'] }}</span>
                        <x-badge variant="neutral">{{ $notif['category'] }}</x-badge>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-layouts.app>
