@php
    $inputId = $name ? $name.'_'.uniqid() : 'time_'.uniqid();
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
            @if($name) for="{{ $inputId }}" @endif
            class="block text-[0.75rem] font-semibold text-[#71757e] uppercase tracking-wider font-body"
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
        style="height: 44px;"
        {{ $attributes->except(['class', 'disabled'])->merge([
            'class' => $currentClasses.($isDisabled ? ' opacity-50 cursor-not-allowed' : ''),
        ]) }}
    />

    @if($hasError)
        <p class="text-red-600 text-[10px] font-medium mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>
