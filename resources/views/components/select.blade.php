@php
    $selectId = $attributes->get('id') ?? $fieldId('select', $placeholder);
    $errorMessage = isset($errors) && $name ? $errors->first($name) : '';
    $hasError = ! empty($errorMessage);
@endphp

<div class="space-y-1.5">
    @if($label)
        <label
            for="{{ $selectId }}"
            class="{{ $labelClasses() }}"
        >
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <select
            id="{{ $selectId }}"
            @if($name) name="{{ $name }}" @endif
            @if($disabled) disabled @endif
            {{ $attributes->except(['id', 'disabled'])->merge([
                'class' => $selectClasses($hasError),
            ]) }}
        >
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif

            @if(!empty($options))
                @foreach($options as $value => $labelText)
                    <option value="{{ $value }}">{{ $labelText }}</option>
                @endforeach
            @endif

            {{ $slot }}
        </select>

        <x-jetax-icon name="chevron-down" size="md" class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant" />
    </div>

    @if($hasError && $errorMessage)
        <p class="{{ $fieldMessageClasses('error') }}">{{ $errorMessage }}</p>
    @endif
</div>
