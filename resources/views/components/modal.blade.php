@props(['id' => 'modal', 'size' => 'md', 'title' => ''])

<div class="modal-overlay" id="{{ $id }}" onclick="if(event.target===this) closeModal('{{ $id }}')">
    <div class="modal-container modal-{{ $size }}">
        @if($title)
            <div class="flex items-center justify-between p-5 sm:p-6 border-b" style="border-color: var(--border-primary);">
                <h3 class="text-lg font-semibold" style="color: var(--text-primary);">{{ $title }}</h3>
                <button class="btn btn-ghost btn-icon btn-sm" onclick="closeModal('{{ $id }}')">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif
        <div class="p-5 sm:p-6">
            {{ $slot }}
        </div>
        @if(isset($footer))
            <div class="flex items-center justify-end gap-3 p-5 sm:p-6 border-t" style="border-color: var(--border-primary);">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
