@php
    $inputId = $name ? $name.'_'.uniqid() : 'currency_'.uniqid();
    $isDisabled = $disabled || $attributes->has('disabled');

    $hasError = false;
    if (isset($errors) && $name) {
        $hasError = $errors->has($name);
    }

    $wrapperClass = $hasError ? $errorWrapperClasses() : $wrapperClasses();
@endphp

<div
    x-data="{
        rawValue: '',
        displayValue: '',
        precision: {{ $precision }},

        init() {
            const initialVal = this.$el.querySelector('input[type=hidden]')?.value ?? '';
            if (initialVal !== '') {
                this.rawValue = parseFloat(initialVal) || 0;
                this.updateDisplay();
            }
        },

        format(value) {
            if (value === '' || value === null || isNaN(value)) {
                return '';
            }
            return new Intl.NumberFormat('{{ $locale }}', {
                minimumFractionDigits: this.precision,
                maximumFractionDigits: this.precision,
            }).format(value);
        },

        updateDisplay() {
            this.displayValue = this.format(this.rawValue);
        },

        onInput(event) {
            const raw = event.target.value.replace(/\D/g, '');
            if (raw === '') {
                this.rawValue = '';
                this.displayValue = '';
                return;
            }
            const numeric = parseInt(raw, 10) / Math.pow(10, this.precision);
            this.rawValue = numeric;
            this.updateDisplay();
            this.$nextTick(() => {
                event.target.value = this.displayValue;
            });
        },

        onBlur(event) {
            if (this.rawValue !== '') {
                this.displayValue = this.format(parseFloat(this.rawValue));
            }
        },
    }"
    class="space-y-1.5"
>
    <div
        class="{{ $wrapperClass }}"
        style="height: 44px;"
    >
        {{-- Símbolo da moeda --}}
        <span
            data-currency-symbol
            class="flex-shrink-0 px-3 text-sm font-medium text-[#71757e] select-none border-r border-[#e2e6f1] h-full flex items-center"
        >{{ $currency }}</span>

        {{-- Input de exibição (formatado) --}}
        <input
            id="{{ $inputId }}"
            type="text"
            inputmode="numeric"
            x-model="displayValue"
            @input="onInput($event)"
            @blur="onBlur($event)"
            @if($isDisabled) disabled @endif
            {{ $attributes->except(['class', 'disabled', 'wire:model', 'wire:model.live', 'wire:model.defer'])->merge([
                'class' => 'flex-1 h-full px-3 text-sm bg-transparent outline-none text-[#1a1d21]'.($isDisabled ? ' cursor-not-allowed' : ''),
            ]) }}
        />

        {{-- Input hidden com o valor raw para wire:model --}}
        @if($attributes->has('wire:model') || $attributes->has('wire:model.live') || $attributes->has('wire:model.defer'))
        <input
            type="hidden"
            @if($attributes->has('wire:model')) wire:model="{{ $attributes->get('wire:model') }}" @endif
            @if($attributes->has('wire:model.live')) wire:model.live="{{ $attributes->get('wire:model.live') }}" @endif
            @if($attributes->has('wire:model.defer')) wire:model.defer="{{ $attributes->get('wire:model.defer') }}" @endif
            x-bind:value="rawValue"
        />
        @endif
    </div>

    @if($hasError)
        <p class="text-red-600 text-[10px] font-medium mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>
