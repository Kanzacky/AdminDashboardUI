@props(['type' => 'text', 'count' => 3, 'height' => '14px'])

<div class="animate-pulse">
    @if($type === 'card')
        <div class="skeleton skeleton-card"></div>
    @elseif($type === 'avatar')
        <div class="skeleton skeleton-avatar"></div>
    @elseif($type === 'table')
        <div class="space-y-3">
            <div class="skeleton" style="height: 40px; border-radius: 8px;"></div>
            @for($i = 0; $i < $count; $i++)
                <div class="skeleton" style="height: 52px; border-radius: 6px;"></div>
            @endfor
        </div>
    @else
        @for($i = 0; $i < $count; $i++)
            <div class="skeleton skeleton-text" style="height: {{ $height }}; width: {{ $i === $count - 1 ? '60%' : '100%' }};"></div>
        @endfor
    @endif
</div>
