@props(['initials' => '??', 'size' => 'md', 'status' => null, 'src' => null])

@php
    $sizeClasses = [
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-12 h-12 text-base',
        'xl' => 'w-16 h-16 text-lg',
    ];
    $statusColors = [
        'active' => 'bg-emerald-400',
        'inactive' => 'bg-gray-400',
        'suspended' => 'bg-red-400',
        'online' => 'bg-emerald-400',
    ];
    $gradients = ['from-indigo-400 to-purple-500', 'from-emerald-400 to-teal-500', 'from-amber-400 to-orange-500', 'from-pink-400 to-rose-500', 'from-cyan-400 to-blue-500'];
    $gradientIndex = ord($initials[0] ?? 'A') % count($gradients);
@endphp

<div class="relative inline-flex flex-shrink-0">
    @if($src)
        <img src="{{ $src }}" alt="" class="rounded-full object-cover {{ $sizeClasses[$size] ?? $sizeClasses['md'] }}">
    @else
        <div class="rounded-full bg-gradient-to-br {{ $gradients[$gradientIndex] }} flex items-center justify-center font-bold text-white {{ $sizeClasses[$size] ?? $sizeClasses['md'] }}">
            {{ $initials }}
        </div>
    @endif
    @if($status)
        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 {{ $statusColors[$status] ?? 'bg-gray-400' }} rounded-full border-2" style="border-color: var(--surface-primary);"></span>
    @endif
</div>
