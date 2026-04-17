@props(['placeholder' => 'Search...', 'filters' => []])

<div class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="relative flex-1">
        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
        <input type="text" placeholder="{{ $placeholder }}" class="form-input pl-10 pr-4">
    </div>
    @foreach($filters as $filter)
        <select class="form-input sm:w-40">
            <option value="">{{ $filter['label'] }}</option>
            @foreach($filter['options'] as $val => $text)
                <option value="{{ $val }}">{{ $text }}</option>
            @endforeach
        </select>
    @endforeach
    {{ $slot }}
</div>
