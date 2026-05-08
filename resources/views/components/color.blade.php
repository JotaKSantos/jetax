<div
    x-data="{ color: '{{ $defaultColor }}' }"
    class="inline-flex items-center gap-3"
>
    {{-- Preview da cor selecionada --}}
    <span
        x-bind:style="'background-color: ' + color"
        data-color-preview
        class="inline-block h-7 w-7 rounded-full border border-outline-variant shadow-sm flex-shrink-0 transition-colors duration-150"
    ></span>

    {{-- Input de cor --}}
    <input
        type="color"
        x-model="color"
        value="{{ $defaultColor }}"
        @if($disabled) disabled @endif
        {{ $attributes->except(['disabled', 'default-color', 'defaultColor']) }}
        class="h-9 w-16 cursor-pointer rounded border border-outline-variant bg-surface-container-lowest p-0.5
               focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1
               disabled:cursor-not-allowed disabled:opacity-50"
    />
</div>
