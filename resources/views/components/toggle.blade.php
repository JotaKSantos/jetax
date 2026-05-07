<div
    x-data="{ on: @js($checked) }"
    class="flex items-center gap-2"
>
    {{-- Hidden input para wire:model --}}
    <input
        type="hidden"
        @if($name) name="{{ $name }}" @endif
        :value="on ? '1' : '0'"
        {{ $attributes->only(['wire:model', 'wire:model.live', 'wire:model.blur', 'wire:model.lazy', 'wire:model.defer', 'wire:model.debounce']) }}
    />

    <button
        type="button"
        id="{{ $toggleId }}"
        @if($disabled) disabled @endif
        @click="if (!$el.disabled) { on = !on }"
        :aria-checked="on.toString()"
        role="switch"
        {{ $attributes->except(['class', 'disabled', 'name', 'label', 'wire:model', 'wire:model.live', 'wire:model.blur', 'wire:model.lazy', 'wire:model.defer', 'wire:model.debounce']) }}
        :class="on
            ? 'bg-[#0061a5]'
            : 'bg-[#e2e6f1]'"
        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full
               border-2 border-transparent transition-all duration-200
               focus:outline-none focus:ring-2 focus:ring-[#0061a5] focus:ring-offset-2
               disabled:opacity-50 disabled:cursor-not-allowed"
    >
        <span
            :class="on ? 'translate-x-5' : 'translate-x-0'"
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full
                   bg-white shadow ring-0 transition-all duration-200"
        ></span>
    </button>

    @if($label)
        <label
            for="{{ $toggleId }}"
            class="text-sm text-[#3d3d4e] cursor-pointer select-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
        >
            {{ $label }}
        </label>
    @endif
</div>
