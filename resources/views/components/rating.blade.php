@php
    // Glifo FA: px da v2 (16/24/32) ÷ 1,35 = 12/18/24 px, os tamanhos nomeados sm/lg/xl (CT-05).
    $starSize = ['sm' => 'sm', 'md' => 'lg', 'lg' => 'xl'][$size] ?? 'lg';
@endphp

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
            <x-jetax-icon
                name="star"
                :size="$starSize"
                class="absolute inset-0 flex items-center justify-center text-gray-300"
            />

            {{-- Estrela preenchida (frente) --}}
            @if($readonly)
                {{-- Modo readonly: suporte a valores parciais com clip-path --}}
                <x-jetax-icon
                    name="star"
                    :size="$starSize"
                    class="absolute inset-0 flex items-center justify-center text-amber-400"
                    style="clip-path: inset(0 {{ max(0, min(100, (1 - max(0, min(1, $value - ($i - 1)))) * 100)) }}% 0 0);"
                />
            @else
                {{-- Modo interativo: highlight por hover ou valor selecionado --}}
                <x-jetax-icon
                    name="star"
                    :size="$starSize"
                    class="absolute inset-0 flex items-center justify-center text-amber-400"
                    x-bind:class="(hoverRating >= {{ $i }} || (hoverRating === 0 && rating >= {{ $i }})) ? 'opacity-100' : 'opacity-0'"
                />
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
