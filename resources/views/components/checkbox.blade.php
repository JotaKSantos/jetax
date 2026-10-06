@php
    $inputId = $attributes->get('id') ?? $checkboxId;
@endphp

<div class="flex items-center gap-2">
    <input
        type="checkbox"
        id="{{ $inputId }}"
        @if($name) name="{{ $name }}" @endif
        @if($checked) checked @endif
        @if($disabled) disabled @endif
        {{ $attributes->except(['id', 'checked', 'disabled', 'name'])->merge(['class' => $inputClasses()]) }}
    />

    @if($label)
        <label
            for="{{ $inputId }}"
            class="text-sm text-on-surface cursor-pointer select-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
        >
            {{ $label }}
        </label>
    @endif
</div>
