@props(['value' => 0, 'max' => 100, 'label' => '', 'showPercent' => true, 'color' => 'brand'])

@php $percent = $max > 0 ? round(($value / $max) * 100) : 0; @endphp

<div {{ $attributes->merge(['class' => '']) }}>
    @if($label || $showPercent)
        <div class="flex items-center justify-between mb-1.5">
            @if($label) <span class="text-sm font-medium" style="color: var(--text-primary);">{{ $label }}</span> @endif
            @if($showPercent) <span class="text-xs font-semibold" style="color: var(--text-secondary);">{{ $percent }}%</span> @endif
        </div>
    @endif
    <div class="progress-track">
        <div class="progress-fill" style="width: {{ $percent }}%;"></div>
    </div>
</div>
