<div
    x-data="{ rating: {{ $value }}, hoverRating: 0, readonly: {{ $readonly ? 'true' : 'false' }}, max: {{ $max }} }"
    {{ $attributes->except(['name', 'wire:model']) }}
    class="inline-flex items-center gap-0.5"
>
    @for ($i = 1; $i <= $max; $i++)
        <span
            class="relative cursor-pointer select-none"
            style="font-size: {{ $sizeClasses() }}; width: {{ $sizeClasses() }}; height: {{ $sizeClasses() }};"
            @if(!$readonly)
                @mouseenter="hoverRating = {{ $i }}"
                @mouseleave="hoverRating = 0"
                @click="rating = {{ $i }}"
            @endif
        >
            {{-- Estrela vazia (fundo) --}}
            <span
                class="material-symbols-outlined absolute inset-0 flex items-center justify-center text-gray-300"
                style="font-size: {{ $sizeClasses() }}; font-variation-settings: 'FILL' 1, 'wght' 400;"
                aria-hidden="true"
            >star</span>

            {{-- Estrela preenchida (frente) --}}
            @if($readonly)
                {{-- Modo readonly: suporte a valores parciais com clip-path --}}
                <span
                    class="material-symbols-outlined absolute inset-0 flex items-center justify-center text-amber-400"
                    style="font-size: {{ $sizeClasses() }}; font-variation-settings: 'FILL' 1, 'wght' 400;
                        clip-path: inset(0 {{ max(0, min(100, (1 - max(0, min(1, $value - ($i - 1)))) * 100)) }}% 0 0);"
                    aria-hidden="true"
                >star</span>
            @else
                {{-- Modo interativo: highlight por hover ou valor selecionado --}}
                <span
                    class="material-symbols-outlined absolute inset-0 flex items-center justify-center text-amber-400"
                    style="font-size: {{ $sizeClasses() }}; font-variation-settings: 'FILL' 1, 'wght' 400;"
                    :style="(hoverRating >= {{ $i }} || (hoverRating === 0 && rating >= {{ $i }})) ? 'font-size: {{ $sizeClasses() }}; font-variation-settings: \'FILL\' 1, \'wght\' 400; opacity: 1;' : 'font-size: {{ $sizeClasses() }}; font-variation-settings: \'FILL\' 1, \'wght\' 400; opacity: 0;'"
                    aria-hidden="true"
                >star</span>
            @endif
        </span>
    @endfor

    @if($name)
        <input
            type="hidden"
            name="{{ $name }}"
            x-model="rating"
            @if($attributes->has('wire:model'))
                wire:model="{{ $attributes->get('wire:model') }}"
            @endif
        />
    @endif
</div>
