{{--
  Binding Livewire (JETAX-003): `wire:model` e qualquer `wire:model.*` são consumidos aqui e
  nunca chegam ao HTML. A digitação grava o valor bruto, como string, por
  `$wire.$set(caminho, valor, live)`, com `live` ligado só pelo modificador `.live`. A leitura usa
  `$wire.get(caminho)` (resolve caminho aninhado) e o `x-effect` esvazia ou atualiza o campo
  quando o servidor muda a propriedade. Sem `wire:model`, o hidden input leva o valor no POST.
--}}
@php
    $isDisabled = $disabled || $attributes->has('disabled');

    $hasError = false;
    if (isset($errors) && $name) {
        $hasError = $errors->has($name);
    }

    $wrapperClass = $hasError ? $errorWrapperClasses() : $wrapperClasses();

    $wireModelKeys = collect($attributes->getAttributes())
        ->keys()
        ->filter(fn (string $key): bool => $key === 'wire:model' || str_starts_with($key, 'wire:model.'))
        ->values()
        ->all();

    $wireModelKey = $wireModelKeys[0] ?? null;
    $wireModelProperty = $wireModelKey !== null ? $attributes->get($wireModelKey) : null;
    $wireModelIsLive = $wireModelKey !== null && in_array('live', explode('.', $wireModelKey), true);
@endphp

<div
    x-data="{
        wireProperty: @js($wireModelProperty),
        wireIsLive: @js($wireModelIsLive),
        rawValue: '',
        displayValue: '',
        precision: {{ $precision }},

        init() {
            const initialVal = this.wireProperty
                ? $wire.get(this.wireProperty)
                : (this.$el.querySelector('input[type=hidden]')?.value ?? '');

            if (initialVal !== '' && initialVal !== null && initialVal !== undefined) {
                this.rawValue = parseFloat(initialVal) || 0;
                this.updateDisplay();
            }
        },

        format(value) {
            if (value === '' || value === null || isNaN(value)) {
                return '';
            }
            return new Intl.NumberFormat(@js($locale), {
                minimumFractionDigits: this.precision,
                maximumFractionDigits: this.precision,
            }).format(value);
        },

        updateDisplay() {
            this.displayValue = this.format(this.rawValue);
        },

        syncFromWire() {
            if (! this.wireProperty) {
                return;
            }

            const current = $wire.get(this.wireProperty);
            const server = (current === '' || current === null || current === undefined)
                ? ''
                : parseFloat(current);

            if (server === '' && this.rawValue !== '') {
                this.rawValue = '';
                this.displayValue = '';
                return;
            }

            if (server !== '' && ! isNaN(server) && server !== this.rawValue) {
                this.rawValue = server;
                this.updateDisplay();
            }
        },

        pushToWire() {
            if (! this.wireProperty) {
                return;
            }

            $wire.$set(
                this.wireProperty,
                this.rawValue === '' ? '' : String(this.rawValue),
                this.wireIsLive,
            );
        },

        onInput(event) {
            const raw = event.target.value.replace(/\D/g, '');
            if (raw === '') {
                this.rawValue = '';
                this.displayValue = '';
                this.pushToWire();
                return;
            }
            const numeric = parseInt(raw, 10) / Math.pow(10, this.precision);
            this.rawValue = numeric;
            this.updateDisplay();
            this.pushToWire();
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
    x-effect="syncFromWire()"
    {{ $attributes->only('class')->merge(['class' => 'space-y-1.5']) }}
>
    @if($label)
        <label
            for="{{ $inputId }}"
            class="block text-[11px] font-bold uppercase tracking-[.06em] text-on-surface-variant font-body"
        >
            {{ $label }}
        </label>
    @endif

    <div
        class="{{ $wrapperClass }}"
        style="height: 44px;"
    >
        {{-- Símbolo da moeda --}}
        <span
            data-currency-symbol
            class="flex-shrink-0 px-3 text-[11px] font-bold tracking-[.06em] text-on-surface-variant select-none border-r border-outline-variant h-full flex items-center"
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
            {{ $attributes->except(['class', 'disabled', ...$wireModelKeys])->merge([
                'class' => 'flex-1 h-full px-3 text-sm bg-transparent outline-none text-on-surface'.($isDisabled ? ' cursor-not-allowed' : ''),
            ]) }}
        />

        {{-- Sem wire:model, o valor bruto vai no POST do formulário HTML. --}}
        @if($wireModelKey === null)
            <input type="hidden" name="{{ $name }}" x-bind:value="rawValue" />
        @endif
    </div>

    @if($hasError)
        <p class="text-error text-[10px] font-medium mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>
