<div
    {{ $attributes }}
    x-data="{ open: {{ $open ? 'true' : 'false' }} }"
>
    {{-- Trigger: slot nomeado ou botão padrão --}}
    <div x-on:click="open = !open" class="cursor-pointer">
        @if(isset($trigger))
            {{ $trigger }}
        @else
            <button
                type="button"
                class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:text-primary transition-colors"
                :aria-expanded="open"
            >
                <span>Mostrar conteúdo</span>
                <x-jetax-icon
                    name="chevron-down"
                    size="lg"
                    class="text-slate-400 transition-transform duration-300"
                    x-bind:class="{ 'rotate-180': open }"
                />
            </button>
        @endif
    </div>

    {{-- Conteúdo colapsável --}}
    <div
        x-show="open"
        x-collapse
        class="overflow-hidden"
    >
        {{ $slot }}
    </div>
</div>
