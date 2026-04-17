@props(['currentPage' => 1, 'totalPages' => 5])

<nav class="flex items-center justify-between" aria-label="Pagination">
    <p class="text-sm" style="color: var(--text-secondary);">
        Showing <span class="font-medium" style="color: var(--text-primary);">{{ ($currentPage - 1) * 10 + 1 }}</span>
        to <span class="font-medium" style="color: var(--text-primary);">{{ min($currentPage * 10, $totalPages * 10) }}</span>
        of <span class="font-medium" style="color: var(--text-primary);">{{ $totalPages * 10 }}</span> results
    </p>
    <div class="flex items-center gap-1">
        <button class="btn btn-secondary btn-sm {{ $currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $currentPage <= 1 ? 'disabled' : '' }}>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
        </button>
        @for($i = 1; $i <= min($totalPages, 5); $i++)
            <button class="btn btn-sm min-w-[36px] {{ $i === $currentPage ? 'btn-primary' : 'btn-ghost' }}">{{ $i }}</button>
        @endfor
        @if($totalPages > 5)
            <span class="px-2 text-sm" style="color: var(--text-tertiary);">...</span>
            <button class="btn btn-ghost btn-sm min-w-[36px]">{{ $totalPages }}</button>
        @endif
        <button class="btn btn-secondary btn-sm {{ $currentPage >= $totalPages ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $currentPage >= $totalPages ? 'disabled' : '' }}>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
        </button>
    </div>
</nav>
