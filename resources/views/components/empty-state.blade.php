@props(['title' => 'No data found', 'description' => 'There are no items to display at the moment.', 'action' => null, 'actionUrl' => '#'])

<div class="flex flex-col items-center justify-center py-16 px-6 text-center animate-fade-in">
    <div class="w-20 h-20 rounded-full flex items-center justify-center mb-5" style="background: var(--surface-tertiary);">
        <svg class="w-10 h-10" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
        </svg>
    </div>
    <h3 class="text-lg font-semibold mb-1" style="color: var(--text-primary);">{{ $title }}</h3>
    <p class="text-sm max-w-sm mb-6" style="color: var(--text-secondary);">{{ $description }}</p>
    @if($action)
        <x-button variant="primary" href="{{ $actionUrl }}">{{ $action }}</x-button>
    @endif
</div>
