@props(['startLabel' => 'Start Date', 'endLabel' => 'End Date'])

<div class="flex flex-col sm:flex-row items-center gap-2">
    <input type="date" class="form-input text-sm" value="2024-03-01">
    <span class="text-sm" style="color: var(--text-tertiary);">to</span>
    <input type="date" class="form-input text-sm" value="2024-03-28">
    <button class="btn btn-secondary btn-sm whitespace-nowrap">Apply</button>
</div>
