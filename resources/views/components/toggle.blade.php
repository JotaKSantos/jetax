{{--
  Binding Livewire (JETAX-002): `wire:model` e qualquer `wire:model.*` são consumidos aqui e
  nunca chegam ao HTML. Com `wire:model`, o estado `on` é um getter sobre `$wire.get(caminho)`
  (resolve caminho aninhado, como `contacts.2.consented`; `$wire[caminho]` devolveria uma
  função, sempre truthy) e a escrita vai por `$wire.$set(caminho, valor, live)`, com `live`
  ligado só pelo modificador `.live`. O `x-effect` reavalia o getter quando o servidor muda a
  propriedade, sem `wire:key` no consumidor. Sem `wire:model`, o estado é local e o hidden
  input leva o valor no POST.
--}}
@php
    $wireModelKey = collect($attributes->getAttributes())
        ->keys()
        ->first(fn (string $key): bool => $key === 'wire:model' || str_starts_with($key, 'wire:model.'));

    $wireModelProperty = $wireModelKey !== null ? $attributes->get($wireModelKey) : null;
    $wireModelIsLive = $wireModelKey !== null && in_array('live', explode('.', $wireModelKey), true);

    $wireModelKeys = collect($attributes->getAttributes())
        ->keys()
        ->filter(fn (string $key): bool => $key === 'wire:model' || str_starts_with($key, 'wire:model.'))
        ->all();
@endphp

<div
    x-data="{
        wireProperty: @js($wireModelProperty),
        wireIsLive: @js($wireModelIsLive),
        localOn: @js($checked),
        get on() {
            return this.wireProperty ? !! $wire.get(this.wireProperty) : this.localOn;
        },
        set on(value) {
            if (this.wireProperty) {
                $wire.$set(this.wireProperty, value, this.wireIsLive);
            } else {
                this.localOn = value;
            }
        },
    }"
    x-effect="$el.dataset.on = on"
    {{ $attributes->only('class')->merge(['class' => 'flex items-center gap-2']) }}
>
    {{-- Hidden input: leva o valor no POST de formulários sem Livewire. --}}
    <input
        type="hidden"
        @if($name) name="{{ $name }}" @endif
        :value="on ? '1' : '0'"
    />

    {{-- Trilho e botão do mockup (Configuracoes.dc.html:972): ligado `success`, desligado
         o traço translúcido do tema (`outline`), botão branco nos dois estados. --}}
    <button
        type="button"
        id="{{ $toggleId }}"
        @if($disabled) disabled @endif
        @click="if (!$el.disabled) { on = !on }"
        :aria-checked="on.toString()"
        role="switch"
        {{ $attributes->except(['class', 'disabled', 'name', 'label', 'checked', ...$wireModelKeys]) }}
        :class="on ? 'bg-success' : 'bg-outline'"
        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full
               border-2 border-transparent transition-all duration-200
               focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2
               focus:ring-offset-surface disabled:opacity-50 disabled:cursor-not-allowed"
    >
        <span
            :class="on ? 'translate-x-5' : 'translate-x-0'"
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full
                   bg-on-primary shadow ring-0 transition-all duration-200"
        ></span>
    </button>

    @if($label)
        <label
            for="{{ $toggleId }}"
            class="text-sm text-on-surface cursor-pointer select-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
        >
            {{ $label }}
        </label>
    @endif
</div>
