<div
    x-data="{ color: '{{ $defaultColor }}' }"
    class="inline-flex items-center gap-3"
>
    {{-- Preview da cor selecionada --}}
    <span
        x-bind:style="'background-color: ' + color"
        data-color-preview
        class="inline-block h-7 w-7 rounded-full border border-[#e2e6f1] shadow-sm flex-shrink-0 transition-colors duration-150"
    ></span>

    {{-- Input de cor --}}
    <input
        type="color"
        x-model="color"
        value="{{ $defaultColor }}"
        @if($disabled) disabled @endif
        {{ $attributes->except(['disabled', 'default-color', 'defaultColor']) }}
        class="h-9 w-16 cursor-pointer rounded border border-[#e2e6f1] bg-white p-0.5
               focus:outline-none focus:ring-2 focus:ring-[#0061a5] focus:ring-offset-1
               disabled:cursor-not-allowed disabled:opacity-50"
    />
</div>
