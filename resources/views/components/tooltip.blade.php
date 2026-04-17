@props(['text' => ''])

<div class="tooltip-container" {{ $attributes }}>
    {{ $slot }}
    <div class="tooltip-content">{{ $text }}</div>
</div>
