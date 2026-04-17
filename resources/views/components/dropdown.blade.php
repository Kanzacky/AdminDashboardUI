@props(['id' => 'dropdown', 'label' => 'Actions'])

<div class="relative inline-flex" id="{{ $id }}-container">
    <button class="btn btn-secondary btn-sm" onclick="toggleDropdown('{{ $id }}')">
        {{ $label }}
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
    </button>
    <div class="dropdown-menu" id="{{ $id }}">
        {{ $slot }}
    </div>
</div>
