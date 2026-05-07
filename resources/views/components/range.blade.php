<div
    x-data="{ rangeValue: {{ $value }} }"
    class="w-full"
>
    <input
        type="range"
        min="{{ $min }}"
        max="{{ $max }}"
        step="{{ $step }}"
        x-model="rangeValue"
        @if($disabled) disabled @endif
        {{ $attributes->except(['min', 'max', 'step', 'value', 'disabled']) }}
        style="
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 6px;
            border-radius: 9999px;
            background: linear-gradient(to right, #0061a5 0%, #0061a5 calc((var(--range-progress, 50) / 100) * 100%), #e2e6f1 calc((var(--range-progress, 50) / 100) * 100%), #e2e6f1 100%);
            outline: none;
            cursor: pointer;
        "
        class="accent-[#0061a5] disabled:opacity-50 disabled:cursor-not-allowed"
        :style="`
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 6px;
            border-radius: 9999px;
            background: linear-gradient(to right, #0061a5 0%, #0061a5 ${((rangeValue - {{ $min }}) / ({{ $max }} - {{ $min }}) * 100).toFixed(1)}%, #e2e6f1 ${((rangeValue - {{ $min }}) / ({{ $max }} - {{ $min }}) * 100).toFixed(1)}%, #e2e6f1 100%);
            outline: none;
            cursor: pointer;
        `"
    />

    @if($showValue)
        <span data-range-value x-text="rangeValue" class="block text-sm text-[#3d3d4e] mt-1 font-medium"></span>
    @endif
</div>
