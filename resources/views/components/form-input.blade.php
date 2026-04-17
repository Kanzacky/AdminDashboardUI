@props(['label' => '', 'name' => '', 'type' => 'text', 'placeholder' => '', 'value' => '', 'hint' => '', 'error' => '', 'required' => false])

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    @if($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}" class="form-input resize-none" rows="4" {{ $required ? 'required' : '' }}>{{ $value }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}" class="form-input {{ $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '' }}" {{ $required ? 'required' : '' }}>
    @endif
    @if($hint && !$error)
        <p class="form-hint">{{ $hint }}</p>
    @endif
    @if($error)
        <p class="form-error">{{ $error }}</p>
    @endif
</div>
