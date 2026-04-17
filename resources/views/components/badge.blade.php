@props(['variant' => 'primary', 'size' => 'md', 'dot' => false])

@php
    $classes = 'badge badge-' . $variant;
    if ($size === 'lg') $classes .= ' text-sm px-3 py-1';
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
    @endif
    {{ $slot }}
</span>
