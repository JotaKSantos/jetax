@aware(['horizontal' => false])
@props(['title' => '', 'description' => '', 'date' => '', 'color' => 'primary', 'icon' => ''])

@php
    // Slot opcional `marker-overlay`: selo sobreposto ao canto do medalhão. Vazio conta como ausente.
    $markerOverlaySlot = $markerOverlay ?? ($__laravel_slots['marker-overlay'] ?? null);
    $hasMarkerOverlay = $markerOverlaySlot !== null && trim((string) $markerOverlaySlot) !== '';
@endphp

@if($horizontal)
    {{-- Layout horizontal: marcador em cima, conteudo embaixo --}}
    <div {{ $attributes->merge(['class' => 'flex flex-col items-center min-w-[140px] px-3 relative']) }}>
        {{-- Marcador circular --}}
        <div class="w-6 h-6 rounded-full {{ $markerBgClass() }} flex items-center justify-center flex-shrink-0 border-2 border-surface-container-lowest z-10{{ $hasMarkerOverlay ? ' relative' : '' }}">
            @if($icon)
                <span class="material-symbols-outlined text-[14px] {{ $iconColorClass() }}">{{ $icon }}</span>
            @else
                <div class="w-2 h-2 rounded-full {{ $markerDotClass() }}"></div>
            @endif

            @if($hasMarkerOverlay)
                <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center" data-jetax-timeline-marker-overlay>{{ $markerOverlaySlot }}</span>
            @endif
        </div>

        {{-- Conteudo --}}
        <div class="mt-3 text-center">
            @if($date)
                <span class="text-[11px] text-on-surface-variant font-medium">{{ $date }}</span>
            @endif

            @if($title)
                <h4 class="text-sm font-semibold text-on-surface">{{ $title }}</h4>
            @endif

            @if($description)
                <p class="text-xs text-on-surface-variant mt-1">{{ $description }}</p>
            @endif

            @if($slot->isNotEmpty())
                <div class="mt-2">{{ $slot }}</div>
            @endif
        </div>
    </div>
@else
    {{-- Layout vertical: marcador a esquerda, conteudo a direita --}}
    <div {{ $attributes->merge(['class' => 'relative flex gap-4 items-start']) }}>
        {{-- Marcador circular --}}
        <div class="w-6 h-6 rounded-full {{ $markerBgClass() }} flex items-center justify-center flex-shrink-0 border-2 border-surface-container-lowest z-10 -ml-9{{ $hasMarkerOverlay ? ' relative' : '' }}">
            @if($icon)
                <span class="material-symbols-outlined text-[14px] {{ $iconColorClass() }}">{{ $icon }}</span>
            @else
                <div class="w-2 h-2 rounded-full {{ $markerDotClass() }}"></div>
            @endif

            @if($hasMarkerOverlay)
                <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center" data-jetax-timeline-marker-overlay>{{ $markerOverlaySlot }}</span>
            @endif
        </div>

        {{-- Conteudo --}}
        <div class="flex-1 -mt-1 pb-6">
            @if($date)
                <span class="text-[11px] text-on-surface-variant font-medium">{{ $date }}</span>
            @endif

            @if($title)
                <h4 class="text-sm font-semibold text-on-surface">{{ $title }}</h4>
            @endif

            @if($description)
                <p class="text-xs text-on-surface-variant mt-1">{{ $description }}</p>
            @endif

            @if($slot->isNotEmpty())
                <div class="mt-2">{{ $slot }}</div>
            @endif
        </div>
    </div>
@endif
