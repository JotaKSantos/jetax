@php
    $inputId = $attributes->get('id') ?? $fieldId('input', (string) $attributes->get('placeholder', ''));
    $isDisabled = $attributes->get('disabled') !== null || $attributes->has('disabled');
    $isReadonly = $readonly || $attributes->get('readonly') !== null || $attributes->has('readonly');
    $maskPattern = $hasMask() ? $maskPattern() : '';
    $errorMessage = isset($errors) && $name ? $errors->first($name) : '';
    $hasServerError = ! empty($errorMessage);
    $hasError = $hasServerError || $state === 'error';
    $currentState = $hasError ? 'error' : $state;
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

    <div class="relative">
        @if($icon)
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">{{ $icon }}</span>
        @endif

        <input
            id="{{ $inputId }}"
            type="{{ $type }}"
            @if($name) name="{{ $name }}" @endif
            @if($isReadonly) readonly @endif
            @if($isDisabled) disabled @endif
            @if($hasMask())
                x-data="{ mask: '{{ $maskPattern }}' }"
                x-mask="{{ $maskPattern }}"
            @endif
            {{ $attributes->except(['id', 'readonly', 'disabled'])->merge([
                'class' => $inputClasses($hasError).($icon ? ' pl-10' : '').($isDisabled ? ' opacity-50 cursor-not-allowed' : ''),
            ]) }}
        />
    </div>

    @if($hasError)
        @php $displayMessage = $hasServerError ? $errorMessage : $message; @endphp
        @if($displayMessage)
            <p class="{{ $messageClasses($hasError) }}">{{ $displayMessage }}</p>
        @endif
    @elseif($message)
        <p class="{{ $messageClasses(false) }}">{{ $message }}</p>
    @endif
</div>
