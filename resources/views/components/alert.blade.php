@props(['type' => 'info', 'title' => '', 'message' => '', 'dismissible' => true])

@php
    $styles = [
        'success' => ['bg' => 'rgba(16,185,129,0.08)', 'border' => 'var(--color-success-500)', 'text' => 'var(--color-success-700)', 'icon' => 'check-circle'],
        'warning' => ['bg' => 'rgba(245,158,11,0.08)', 'border' => 'var(--color-warning-500)', 'text' => 'var(--color-warning-600)', 'icon' => 'exclamation-triangle'],
        'danger' => ['bg' => 'rgba(239,68,68,0.08)', 'border' => 'var(--color-danger-500)', 'text' => 'var(--color-danger-700)', 'icon' => 'x-circle'],
        'info' => ['bg' => 'rgba(99,102,241,0.08)', 'border' => 'var(--color-brand-500)', 'text' => 'var(--color-brand-700)', 'icon' => 'information-circle'],
    ];
    $s = $styles[$type] ?? $styles['info'];
@endphp

<div class="flex items-start gap-3 p-4 rounded-xl border-l-4 animate-fade-in-up" style="background: {{ $s['bg'] }}; border-left-color: {{ $s['border'] }};">
    <div class="flex-shrink-0 mt-0.5" style="color: {{ $s['border'] }};">
        @if($type === 'success')
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        @elseif($type === 'warning')
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
        @elseif($type === 'danger')
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        @else
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
        @endif
    </div>
    <div class="flex-1 min-w-0">
        @if($title)
            <h4 class="text-sm font-semibold mb-0.5" style="color: {{ $s['text'] }};">{{ $title }}</h4>
        @endif
        <p class="text-sm" style="color: {{ $s['text'] }}; opacity: 0.85;">{{ $message ?: $slot }}</p>
    </div>
    @if($dismissible)
        <button class="flex-shrink-0 p-1 rounded-lg transition-colors hover:bg-black/5" style="color: {{ $s['text'] }};" onclick="this.closest('[class*=flex]').remove()">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    @endif
</div>
