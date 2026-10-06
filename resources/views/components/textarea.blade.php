@php
    $textareaId = $attributes->get('id') ?? $fieldId('textarea', (string) $attributes->get('placeholder', ''));
    $isDisabled = $attributes->get('disabled') !== null || $attributes->has('disabled');
    $errorMessage = isset($errors) && $name ? $errors->first($name) : '';
    $hasServerError = ! empty($errorMessage);
    $hasError = $hasServerError || $state === 'error';
@endphp

<div class="space-y-1.5">
    @if($label)
        <label
            for="{{ $textareaId }}"
            class="{{ $labelClasses() }}"
        >
            {{ $label }}
        </label>
    @endif

    <textarea
        id="{{ $textareaId }}"
        @if($name) name="{{ $name }}" @endif
        rows="{{ $rows }}"
        @if($isDisabled) disabled @endif
        @if($autoResize)
            x-data="{ autoResize(el) { el.style.height = 'auto'; el.style.height = el.scrollHeight + 'px'; } }"
            x-init="autoResize($el)"
            x-on:input="autoResize($el)"
        @endif
        {{ $attributes->except(['id', 'disabled'])->merge([
            'class' => $textareaClasses($hasError),
        ]) }}
    >{{ $slot }}</textarea>

    @if($hasError)
        @php $displayMessage = $hasServerError ? $errorMessage : $message; @endphp
        @if($displayMessage)
            <p class="{{ $messageClasses($hasError) }}">{{ $displayMessage }}</p>
        @endif
    @elseif($message)
        <p class="{{ $messageClasses(false) }}">{{ $message }}</p>
    @endif
</div>
