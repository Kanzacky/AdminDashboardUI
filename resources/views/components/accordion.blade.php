@props(['items' => []])

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @foreach($items as $index => $item)
        <div class="card p-0 overflow-hidden accordion-item">
            <button class="w-full flex items-center justify-between p-4 sm:p-5 text-left transition-colors hover:bg-[var(--surface-secondary)]" onclick="toggleAccordion(this)">
                <span class="font-medium text-sm sm:text-base" style="color: var(--text-primary);">{{ $item['title'] ?? $item['question'] ?? '' }}</span>
                <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-200 accordion-chevron" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="accordion-content hidden">
                <div class="px-4 sm:px-5 pb-4 sm:pb-5 text-sm leading-relaxed" style="color: var(--text-secondary);">
                    {{ $item['content'] ?? $item['answer'] ?? '' }}
                </div>
            </div>
        </div>
    @endforeach
</div>
