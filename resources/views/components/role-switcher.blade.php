@props(['currentRole' => 'superadmin'])

@php
    $roles = [
        'superadmin' => ['label' => 'Super Admin', 'color' => '#ef4444'],
        'admin' => ['label' => 'Admin', 'color' => '#6366f1'],
        'manager' => ['label' => 'Manager', 'color' => '#d946ef'],
        'staff' => ['label' => 'Staff', 'color' => '#10b981'],
        'viewer' => ['label' => 'Viewer', 'color' => '#94a3b8'],
    ];
@endphp

<div class="fixed bottom-6 right-6 z-50" id="role-switcher">
    <div class="relative">
        {{-- Expanded Panel --}}
        <div class="absolute bottom-16 right-0 w-56 rounded-xl p-2 hidden" id="role-switcher-panel"
             style="background: var(--surface-primary); border: 1px solid var(--border-primary); box-shadow: var(--shadow-xl);">
            <div class="px-3 py-2 mb-1">
                <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--text-tertiary);">Switch Role</p>
            </div>
            @foreach($roles as $slug => $role)
                <a href="{{ url()->current() }}?role={{ $slug }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ $currentRole === $slug ? 'bg-[var(--surface-tertiary)]' : 'hover:bg-[var(--surface-secondary)]' }}">
                    <span class="w-3 h-3 rounded-full flex-shrink-0" style="background: {{ $role['color'] }};"></span>
                    <span class="text-sm font-medium {{ $currentRole === $slug ? 'text-[var(--text-primary)]' : 'text-[var(--text-secondary)]' }}">{{ $role['label'] }}</span>
                    @if($currentRole === $slug)
                        <svg class="w-4 h-4 ml-auto" style="color: var(--color-brand-500);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Toggle Button --}}
        <button onclick="document.getElementById('role-switcher-panel').classList.toggle('hidden')"
                class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110"
                style="background: linear-gradient(135deg, var(--color-brand-600), var(--color-accent-600));"
                title="Switch demo role">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
        </button>
    </div>
</div>
