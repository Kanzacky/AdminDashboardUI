@props(['active' => false, 'label' => '', 'name' => ''])

<label class="flex items-center gap-3 cursor-pointer select-none">
    <div class="toggle-switch {{ $active ? 'active' : '' }}" onclick="this.classList.toggle('active')" data-name="{{ $name }}"></div>
    @if($label)
        <span class="text-sm font-medium" style="color: var(--text-primary);">{{ $label }}</span>
    @endif
</label>
