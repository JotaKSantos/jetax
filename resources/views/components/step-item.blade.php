@props(['label' => '', 'description' => '', 'step' => 1])
@aware(['current' => 1, 'clickable' => false, 'vertical' => false])

@php
    $isCompleted = $step < $current;
    $isActive    = $step === $current;
    $isPending   = $step > $current;
@endphp

@if($vertical)
    {{-- Layout Vertical --}}
    <div
        {{ $attributes->merge(['class' => 'flex items-stretch last:items-start']) }}
        @if($isCompleted && $clickable)
            x-on:click="current = {{ $step }}"
            style="cursor: pointer;"
        @endif
    >
        {{-- Coluna do indicador + linha vertical --}}
        <div class="flex flex-col items-center">
            <div class="
                w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold shrink-0
                @if($isCompleted) bg-primary text-white
                @elseif($isActive) bg-primary text-white ring-2 ring-primary ring-offset-2
                @else text-on-surface-variant border-2 border-outline-variant
                @endif
            ">
                @if($isCompleted)
                    <x-jetax-icon name="check" size="sm" />
                @else
                    {{ $step }}
                @endif
            </div>

            {{-- Linha conectora vertical (oculta no último item via CSS do container) --}}
            <div class="step-line w-px flex-1 my-1
                @if($isCompleted) bg-primary
                @else bg-outline-variant
                @endif
            "></div>
        </div>

        {{-- Label e descrição à direita --}}
        <div class="step-label ml-3 pb-6">
            <span class="
                text-sm font-medium
                @if($isActive) text-primary
                @elseif($isPending) text-on-surface-variant
                @else text-on-surface
                @endif
            ">{{ $label }}</span>

            @if($description)
                <p class="text-xs text-on-surface-variant mt-0.5">{{ $description }}</p>
            @endif
        </div>
    </div>
@else
    {{-- Layout Horizontal --}}
    <div
        {{ $attributes->merge(['class' => 'flex-1 flex flex-col items-center']) }}
        style="position: relative;{{ $isCompleted && $clickable ? ' cursor: pointer;' : '' }}"
        @if($isCompleted && $clickable)
            x-on:click="current = {{ $step }}"
        @endif
    >
        {{-- Meia-linha esquerda (oculta no primeiro step) --}}
        @if($step > 1)
            <div class="h-px
                @if($isCompleted || $isActive) bg-primary
                @else bg-outline-variant
                @endif
            " style="position: absolute; top: 15px; left: 0; width: calc(50% - 16px);"></div>
        @endif

        {{-- Indicador --}}
        <div class="
            w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold
            @if($isCompleted) bg-primary text-white
            @elseif($isActive) bg-primary text-white ring-2 ring-primary ring-offset-2
            @else text-on-surface-variant border-2 border-outline-variant
            @endif
        " style="position: relative; z-index: 1;">
            @if($isCompleted)
                <x-jetax-icon name="check" size="sm" />
            @else
                {{ $step }}
            @endif
        </div>

        {{-- Meia-linha direita (oculta no último step via CSS) --}}
        <div class="step-line h-px
            @if($isCompleted) bg-primary
            @else bg-outline-variant
            @endif
        " style="position: absolute; top: 15px; right: 0; width: calc(50% - 16px);"></div>

        {{-- Label e descrição --}}
        <div class="mt-2 text-center">
            <span class="
                text-xs font-medium
                @if($isActive) text-primary
                @elseif($isPending) text-on-surface-variant
                @else text-on-surface
                @endif
            ">{{ $label }}</span>

            @if($description)
                <p class="text-xs text-on-surface-variant mt-0.5">{{ $description }}</p>
            @endif
        </div>
    </div>
@endif
