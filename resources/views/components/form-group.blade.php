@php
    $errorMessage = isset($errors) && $name ? $errors->first($name) : '';
    $hasError = ! empty($errorMessage);
@endphp

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if($label)
        <label
            @if($name) for="{{ $name }}" @endif
            class="{{ $labelClasses() }}"
        >
            {{ $label }}
            @if($required)
                <span class="text-error ml-0.5">*</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if($hasError)
        <p class="{{ $fieldMessageClasses('error') }}">{{ $errorMessage }}</p>
    @elseif($hint)
        <p class="{{ $fieldMessageClasses() }}">{{ $hint }}</p>
    @endif
</div>
