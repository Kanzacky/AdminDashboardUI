@props(['tabs' => [], 'active' => '', 'id' => 'tabs'])

<div {{ $attributes->merge(['class' => '']) }}>
    <div class="flex border-b gap-0 overflow-x-auto" style="border-color: var(--border-primary);" id="{{ $id }}-nav">
        @foreach($tabs as $key => $label)
            <button class="px-4 py-3 text-sm font-medium whitespace-nowrap border-b-2 transition-colors tab-btn
                {{ $active === $key ? 'border-[var(--color-brand-500)] text-[var(--color-brand-600)]' : 'border-transparent text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:border-[var(--border-primary)]' }}"
                onclick="switchTab('{{ $id }}', '{{ $key }}')" data-tab="{{ $key }}">
                {{ $label }}
            </button>
        @endforeach
    </div>
    <div id="{{ $id }}-content" class="pt-5">
        {{ $slot }}
    </div>
</div>
