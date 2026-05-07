@php
    $selectId = $name ? $name.'_'.uniqid() : 'select_'.uniqid();
    $errorMessage = isset($errors) && $name ? $errors->first($name) : '';
    $hasError = ! empty($errorMessage);
@endphp

<div class="space-y-1.5">
    @if($label)
        <label
            @if($name) for="{{ $selectId }}" @endif
            class="block text-[0.75rem] font-semibold text-[#71757e] uppercase tracking-wider font-body"
        >
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <select
            id="{{ $selectId }}"
            @if($name) name="{{ $name }}" @endif
            @if($disabled) disabled @endif
            style="height: 44px;"
            {{ $attributes->except(['class', 'disabled'])->merge([
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

        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-[20px]">expand_more</span>
    </div>

    @if($hasError && $errorMessage)
        <p class="text-red-600 text-[10px] font-medium mt-1">{{ $errorMessage }}</p>
    @endif
</div>
