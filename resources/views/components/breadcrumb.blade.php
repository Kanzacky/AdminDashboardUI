@props(['items' => []])

<nav class="flex items-center gap-2 mb-4 text-sm" aria-label="Breadcrumb">
    <a href="{{ route('dashboard') }}?role={{ request()->query('role', 'superadmin') }}" class="flex items-center gap-1 transition-colors" style="color: var(--text-tertiary);" onmouseover="this.style.color='var(--color-brand-500)'" onmouseout="this.style.color='var(--text-tertiary)'">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
    </a>
    @foreach($items as $item)
        <svg class="w-3.5 h-3.5" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
        @if(isset($item['url']))
            <a href="{{ $item['url'] }}" class="transition-colors hover:text-[var(--color-brand-500)]" style="color: var(--text-tertiary);">{{ $item['label'] }}</a>
        @else
            <span class="font-medium" style="color: var(--text-primary);">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
