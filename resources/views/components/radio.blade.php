<div class="flex items-center gap-2">
    <input
        type="radio"
        id="{{ $radioId }}"
        @if($name) name="{{ $name }}" @endif
        @if($value) value="{{ $value }}" @endif
        @if($disabled) disabled @endif
        {{ $attributes->except(['class', 'disabled', 'name', 'value']) }}
        class="appearance-none w-4 h-4 rounded-full border border-outline-variant bg-surface-input cursor-pointer
               checked:border-primary checked:border-4
               focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1
               disabled:opacity-50 disabled:cursor-not-allowed
               transition-colors"
    />

    @if($label)
        <label
            for="{{ $radioId }}"
            class="text-sm text-on-surface cursor-pointer select-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
        >
            {{ $label }}
        </label>
    @endif
</div>
