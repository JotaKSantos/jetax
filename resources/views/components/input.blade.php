@php
    $inputId = $name ? $name.'_'.uniqid() : 'input_'.uniqid();
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
            @if($name) for="{{ $inputId }}" @endif
            class="block text-[0.75rem] font-semibold text-[#71757e] uppercase tracking-wider font-body"
        >
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if($icon)
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px] pointer-events-none">{{ $icon }}</span>
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
            style="height: 44px;"
            {{ $attributes->except(['class', 'readonly', 'disabled'])->merge([
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
