@props(['id' => 'drawer', 'title' => '', 'width' => '400px'])

<div class="drawer-overlay" id="{{ $id }}-overlay" onclick="closeDrawer('{{ $id }}')"></div>
<div class="drawer-panel" id="{{ $id }}" style="width: {{ $width }}; max-width: 90vw;">
    <div class="flex items-center justify-between p-5 border-b" style="border-color: var(--border-primary);">
        <h3 class="text-lg font-semibold" style="color: var(--text-primary);">{{ $title }}</h3>
        <button class="btn btn-ghost btn-icon btn-sm" onclick="closeDrawer('{{ $id }}')">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
    <div class="p-5">
        {{ $slot }}
    </div>
</div>
