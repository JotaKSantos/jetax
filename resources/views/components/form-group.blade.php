@php
    $errorMessage = isset($errors) && $name ? $errors->first($name) : '';
    $hasError = ! empty($errorMessage);
@endphp

<div class="space-y-1.5">
    @if($label)
        <label
            @if($name) for="{{ $name }}" @endif
            class="block text-[0.75rem] font-semibold text-[#71757e] uppercase tracking-wider font-body"
        >
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-0.5">*</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if($hasError)
        <p class="text-red-600 text-[10px] font-medium mt-1">{{ $errorMessage }}</p>
    @elseif($hint)
        <p class="text-slate-500 text-[10px] font-medium mt-1">{{ $hint }}</p>
    @endif
</div>
