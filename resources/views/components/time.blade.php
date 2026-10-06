@php
    $inputId = $attributes->get('id') ?? $fieldId('time');
    $isDisabled = $disabled || $attributes->has('disabled');

    $hasError = false;
    if (isset($errors) && $name) {
        $hasError = $errors->has($name);
    }

    $currentClasses = $hasError ? $errorClasses() : $inputClasses();
@endphp

<div class="space-y-1.5">
    @if($label)
        <label
            for="{{ $inputId }}"
            class="{{ $labelClasses() }}"
        >
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $inputId }}"
        type="time"
        @if($name) name="{{ $name }}" @endif
        step="{{ $step }}"
        @if($isDisabled) disabled @endif
        {{ $attributes->except(['id', 'disabled'])->merge([
            'class' => $currentClasses.($isDisabled ? ' opacity-50 cursor-not-allowed' : ''),
        ]) }}
    />

    @if($hasError)
        <p class="{{ $fieldMessageClasses('error') }}">{{ $errors->first($name) }}</p>
    @endif
</div>
