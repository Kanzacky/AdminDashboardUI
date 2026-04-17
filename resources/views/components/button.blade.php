@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button', 'href' => null, 'icon' => false])

@php
    $classes = 'btn btn-' . $variant;
    if ($size === 'sm') $classes .= ' btn-sm';
    if ($size === 'lg') $classes .= ' btn-lg';
    if ($icon) $classes .= ' btn-icon';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
