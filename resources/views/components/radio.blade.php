<div class="flex items-center gap-2">
    <input
        type="radio"
        id="{{ $radioId }}"
        @if($name) name="{{ $name }}" @endif
        @if($value) value="{{ $value }}" @endif
        @if($disabled) disabled @endif
        {{ $attributes->except(['class', 'disabled', 'name', 'value']) }}
        class="appearance-none w-4 h-4 rounded-full border border-[#e2e6f1] bg-[#f3f3ff] cursor-pointer
               checked:border-[#0061a5] checked:border-4
               focus:outline-none focus:ring-2 focus:ring-[#0061a5] focus:ring-offset-1
               disabled:opacity-50 disabled:cursor-not-allowed
               transition-colors"
    />

    @if($label)
        <label
            for="{{ $radioId }}"
            class="text-sm text-[#3d3d4e] cursor-pointer select-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
        >
            {{ $label }}
        </label>
    @endif
</div>
