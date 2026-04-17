@props(['label' => '', 'name' => '', 'options' => [], 'selected' => '', 'hint' => '', 'required' => false])

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <select name="{{ $name }}" id="{{ $name }}" class="form-input" {{ $required ? 'required' : '' }}>
        <option value="">Select an option</option>
        @foreach($options as $val => $text)
            <option value="{{ $val }}" {{ $selected == $val ? 'selected' : '' }}>{{ $text }}</option>
        @endforeach
    </select>
    @if($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif
</div>
