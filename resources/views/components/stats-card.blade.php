<div {{ $attributes->merge(['class' => $cardClasses()]) }}>
    {{-- Cabeçalho: label e ícone --}}
    <div class="flex justify-between items-start">
        <span class="{{ $labelClasses() }}">{{ $label }}</span>

        @if($icon)
            <div class="{{ $iconContainerClasses() }}">
                <span class="{{ $iconClasses() }}">{{ $icon }}</span>
            </div>
        @endif
    </div>

    {{-- Valor principal --}}
    <div class="flex items-end justify-between gap-4">
        <p class="{{ $valueClasses() }}">{{ $value }}</p>

        @if($trendValue)
            <div class="{{ $trendClasses() }}">
                <span class="material-symbols-outlined text-sm">{{ $trendIcon() }}</span>
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
</div>
