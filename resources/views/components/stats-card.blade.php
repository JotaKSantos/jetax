
<div {{ $attributes->merge(['class' => $cardClasses()]) }}>
    @if($isFigure())
        {{-- Arranjo figure: ícone translúcido à esquerda, valor sobre o rótulo à direita --}}
        @if($icon)
            <div class="{{ $iconContainerClasses() }}">
                <x-jetax-icon :name="$icon" size="lg" :class="$iconClasses()" />
            </div>
        @endif

        <div class="flex-1 min-w-0 flex flex-col items-end gap-1 text-right">
            <p class="{{ $valueClasses() }}">{{ $value }}</p>

            <span class="inline-flex items-center gap-1.5">
                @if($hint !== '')
                    <span class="{{ $hintClasses() }}" title="{{ $hint }}" aria-label="{{ $hint }}">?</span>
                @endif
                <span class="{{ $labelClasses() }}">{{ $label }}</span>
            </span>

            @if($trendValue)
                <div class="{{ $trendClasses() }}">
                    <x-jetax-icon :name="$trendIcon()" size="14" :class="$trendIconClasses()" />
                    {{ $trendValue }}
                </div>
            @endif

            @if($slot->isNotEmpty())
                <div>
                    {{ $slot }}
                </div>
            @endif
        </div>
    @else
        {{-- Cabeçalho: label e ícone --}}
        <div class="flex justify-between items-start">
            <span class="inline-flex items-center gap-1.5">
                @if($hint !== '')
                    <span class="{{ $hintClasses() }}" title="{{ $hint }}" aria-label="{{ $hint }}">?</span>
                @endif
                <span class="{{ $labelClasses() }}">{{ $label }}</span>
            </span>

            @if($icon)
                <div class="{{ $iconContainerClasses() }}">
                    <x-jetax-icon :name="$icon" size="lg" :class="$iconClasses()" />
                </div>
            @endif
        </div>

        {{-- Valor principal --}}
        <div class="flex items-end justify-between gap-4">
            <p class="{{ $valueClasses() }}">{{ $value }}</p>

            @if($trendValue)
                <div class="{{ $trendClasses() }}">
                    <x-jetax-icon :name="$trendIcon()" size="14" :class="$trendIconClasses()" />
                    {{ $trendValue }}
                </div>
            @endif
        </div>

        {{-- Slot opcional para conteúdo extra (subtítulo, progresso etc.) --}}
        @if($slot->isNotEmpty())
            <div>
                {{ $slot }}
            </div>
        @endif
    @endif
</div>
