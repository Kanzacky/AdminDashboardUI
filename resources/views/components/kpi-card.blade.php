@props(['title', 'value', 'change' => null, 'trend' => 'up', 'icon' => 'chart-bar', 'color' => 'brand', 'description' => ''])

@php
    $colorMap = [
        'brand' => ['bg' => 'rgba(99, 102, 241, 0.1)', 'text' => 'var(--color-brand-500)', 'darkBg' => 'rgba(99, 102, 241, 0.15)'],
        'success' => ['bg' => 'rgba(16, 185, 129, 0.1)', 'text' => 'var(--color-success-500)', 'darkBg' => 'rgba(16, 185, 129, 0.15)'],
        'warning' => ['bg' => 'rgba(245, 158, 11, 0.1)', 'text' => 'var(--color-warning-500)', 'darkBg' => 'rgba(245, 158, 11, 0.15)'],
        'accent' => ['bg' => 'rgba(217, 70, 239, 0.1)', 'text' => 'var(--color-accent-500)', 'darkBg' => 'rgba(217, 70, 239, 0.15)'],
        'danger' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'text' => 'var(--color-danger-500)', 'darkBg' => 'rgba(239, 68, 68, 0.15)'],
    ];
    $c = $colorMap[$color] ?? $colorMap['brand'];
@endphp

<div class="card card-interactive p-5 sm:p-6 animate-fade-in-up" style="opacity: 0; animation-fill-mode: forwards;">
    <div class="flex items-start justify-between">
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium mb-1" style="color: var(--text-secondary);">{{ $title }}</p>
            <p class="text-2xl sm:text-3xl font-bold tracking-tight" style="color: var(--text-primary);">{{ $value }}</p>
            @if($change)
                <div class="flex items-center gap-1.5 mt-2">
                    @if($trend === 'up')
                        <span class="inline-flex items-center gap-0.5 text-xs font-semibold px-1.5 py-0.5 rounded-full" style="background: rgba(16, 185, 129, 0.1); color: var(--color-success-500);">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" /></svg>
                            {{ $change }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-0.5 text-xs font-semibold px-1.5 py-0.5 rounded-full" style="background: rgba(239, 68, 68, 0.1); color: var(--color-danger-500);">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5l15 15m0 0V8.25m0 11.25H8.25" /></svg>
                            {{ $change }}
                        </span>
                    @endif
                    <span class="text-xs" style="color: var(--text-tertiary);">{{ $description }}</span>
                </div>
            @endif
        </div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 ml-4" style="background: {{ $c['bg'] }};">
            <x-icon :name="$icon" class="w-6 h-6" style="color: {{ $c['text'] }};" />
        </div>
    </div>
</div>
