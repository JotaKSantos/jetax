<div
    {{ $attributes->merge(['class' => 'relative inline-block']) }}
    data-popover-open="{{ $isOpen() ? 'true' : 'false' }}"
    x-data="{
        open: @js($isOpen()),
        controlled: @js($controlled()),
        @include('jetax::partials.floating-panel', ['vertical' => $vertical(), 'horizontal' => $horizontal(), 'panelRef' => 'panel'])

        init() {
            if (this.open) {
                this.$nextTick(() => this.place());
            }

            {{-- Controlado: o Livewire reescreve `data-popover-open` no morph, mas não
                 reavalia o `x-data`; o observer leva o valor do servidor para `open`. --}}
            if (this.controlled) {
                new MutationObserver(() => this.show(this.$el.dataset.popoverOpen === 'true'))
                    .observe(this.$el, { attributes: true, attributeFilter: ['data-popover-open'] });
            }
        },

        show(value) {
            this.open = value;

            if (value) {
                this.$nextTick(() => this.place());
            }
        },

        toggle() {
            if (! this.controlled) {
                this.show(! this.open);
            }
        },
    }"
    x-on:keydown.escape.window="if (open) { open = false; $dispatch('close') }"
    x-on:click.outside="if (open) { open = false; $dispatch('close') }"
    x-on:scroll.window.passive="open && place()"
    x-on:resize.window="open && place()"
>
    {{-- Gatilho: slot padrão. No modo controlado o clique fica com o consumidor. --}}
    <div x-ref="trigger" class="popover-trigger" x-on:click="toggle()">
        {{ $slot }}
    </div>

    {{-- Painel: `fixed` pelo retângulo do gatilho (partials/floating-panel), sem teleporte,
         para o `overflow-hidden` de um card não recortá-lo. --}}
    <div
        x-ref="panel"
        x-show="open"
        x-bind:style="menuStyle"
        @if (config('jetax.animations', true))
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @endif
        class="fixed z-50 bg-surface-container-high rounded-xl shadow-2xl border border-outline-variant p-4 min-w-max text-on-surface"
        role="dialog"
        data-popover-panel
        @unless ($isOpen()) style="display: none;" @endunless
    >
        {{ $content ?? '' }}
    </div>
</div>
