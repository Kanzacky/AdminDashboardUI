@props(['padding' => 'p-5 sm:p-6', 'hover' => false])

<div {{ $attributes->merge(['class' => 'card ' . ($hover ? 'card-interactive' : '') . ' ' . $padding]) }}>
    @if(isset($header))
        <div class="flex items-center justify-between mb-4 pb-4" style="border-bottom: 1px solid var(--border-secondary);">
            {{ $header }}
        </div>
    @endif

    {{ $slot }}

    @if(isset($footer))
        <div class="mt-4 pt-4" style="border-top: 1px solid var(--border-secondary);">
            {{ $footer }}
        </div>
    @endif
</div>
