<div class="flex items-center gap-2">
    <input
        type="checkbox"
        id="{{ $checkboxId }}"
        @if($name) name="{{ $name }}" @endif
        @if($checked) checked @endif
        @if($disabled) disabled @endif
        {{ $attributes->except(['class', 'checked', 'disabled', 'name']) }}
        class="appearance-none w-4 h-4 rounded border border-[#e2e6f1] bg-[#f3f3ff] cursor-pointer
               checked:bg-[#0061a5] checked:border-[#0061a5] checked:bg-[url('data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%2016%2016%22%20fill%3D%22white%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M12.207%204.793a1%201%200%20010%201.414l-5%205a1%201%200%2001-1.414%200l-2-2a1%201%200%20011.414-1.414L6.5%209.086l4.293-4.293a1%201%200%20011.414%200z%22%2F%3E%3C%2Fsvg%3E')]
               checked:bg-center checked:bg-no-repeat checked:bg-[length:14px_14px]
               focus:outline-none focus:ring-2 focus:ring-[#0061a5] focus:ring-offset-1
               disabled:opacity-50 disabled:cursor-not-allowed
               transition-colors"
    />

    @if($label)
        <label
            for="{{ $checkboxId }}"
            class="text-sm text-[#3d3d4e] cursor-pointer select-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
        >
            {{ $label }}
        </label>
    @endif
</div>
