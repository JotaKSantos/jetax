<div
    {{ $attributes->merge(['class' => 'relative inline-block']) }}
    x-data="{
        open: false,
        @include('jetax::partials.floating-panel', ['vertical' => $vertical(), 'horizontal' => $horizontal()])

        toggle() {
            this.open = ! this.open;

            if (this.open) {
                this.$nextTick(() => this.place());
            }
        },
    }"
    x-on:keydown.escape.window="open = false"
    x-on:scroll.window.passive="open && place()"
    x-on:resize.window="open && place()"
    x-on:click.outside="if (! $refs.menu?.contains($event.target)) open = false"
>
    {{-- Trigger: `h-full` faz o wrapper acompanhar a altura de um pai esticado (flex
         `items-stretch`), para o botão do gatilho que pede `h-full` não encolher. Fora de
         contexto esticado, `height:100%` resolve para `auto` e não tem efeito. --}}
    <div x-ref="trigger" x-on:click="toggle()" class="h-full">
        {{ $trigger }}
    </div>

    {{-- Menu --}}
    <div
        x-ref="menu"
        x-show="open"
        x-bind:style="menuStyle"
        x-on:click="open = false"
        @if (config('jetax.animations', true))
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        @endif
        class="fixed z-50 min-w-[12rem] w-max max-w-[20rem] bg-surface-container-high rounded-xl architect-shadow ring-1 ring-outline-variant overflow-hidden"
        style="display: none;"
    >
        <div class="py-2">
            {{ $slot }}
        </div>
    </div>
</div>
