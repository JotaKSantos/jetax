@php
    $firstItem = $firstItem();
    $lastItem  = $lastItem();
    $total     = $total();
    $current   = $currentPage();
    $lastPage  = $lastPage();
    $isFirst   = $isFirstPage();
    $isLast    = $isLastPage();
    $elements  = $elements();
@endphp

<div {{ $attributes->merge(['class' => 'p-4 bg-surface-container-low flex flex-wrap items-center justify-between gap-4']) }}>

    {{-- Indicador de resultado --}}
    <div class="text-sm text-outline">
        Mostrando
        <span class="font-bold text-on-surface">{{ $firstItem }}</span>
        a
        <span class="font-bold text-on-surface">{{ $lastItem }}</span>
        de
        <span class="font-bold text-on-surface">{{ number_format($total, 0, ',', '.') }}</span>
        resultados
    </div>

    {{-- Controles: seletor + navegação --}}
    <div class="flex items-center gap-6">

        {{-- Seletor de itens por página --}}
        <div class="flex items-center gap-3">
            <span class="text-sm text-outline hidden md:inline">Linhas por página:</span>
            <select
                name="per_page"
                class="bg-white border border-outline-variant rounded-lg text-xs font-semibold focus:ring-primary focus:border-primary py-1.5 pl-3 pr-8 transition-colors"
                onchange="window.location.href = '{{ $paginator->url(1) }}'.replace(/([?&]per_page=)[^&]*/, '$1' + this.value).replace(/([?&]page=)[^&]*/, '$1' + '1') || window.location.pathname + '?per_page=' + this.value"
            >
                @foreach(\Jetax\DesignSystem\View\Components\Pagination::PER_PAGE_OPTIONS as $option)
                    <option
                        value="{{ $option }}"
                        @selected($paginator->perPage() === $option)
                    >{{ $option }}</option>
                @endforeach
            </select>
        </div>

        {{-- Navegação de páginas --}}
        <nav class="flex items-center gap-1" aria-label="Paginação">

            {{-- Botão Anterior --}}
            @if($isFirst)
                <button
                    type="button"
                    disabled
                    aria-disabled="true"
                    aria-label="Página anterior"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-outline/40 cursor-not-allowed transition-all"
                >
                    <span class="material-symbols-outlined text-lg">chevron_left</span>
                </button>
            @else
                <a
                    href="{{ $previousPageUrl() }}"
                    wire:navigate
                    aria-label="Página anterior"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-outline hover:bg-white transition-all"
                >
                    <span class="material-symbols-outlined text-lg">chevron_left</span>
                </a>
            @endif

            {{-- Números de página com elipses (ocultos no mobile) --}}
            <div class="hidden md:flex items-center gap-1">
                @foreach($elements as $element)
                    @if($element === '...')
                        <span class="text-outline text-xs px-1">...</span>
                    @elseif($element === $current)
                        <button
                            type="button"
                            aria-current="page"
                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white text-xs font-bold"
                        >{{ $element }}</button>
                    @else
                        <a
                            href="{{ $pageUrl($element) }}"
                            wire:navigate
                            aria-label="Ir para a página {{ $element }}"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-on-surface-variant hover:bg-white text-xs font-medium transition-all"
                        >{{ $element }}</a>
                    @endif
                @endforeach
            </div>

            {{-- Indicador de página no mobile --}}
            <span class="md:hidden text-xs text-on-surface-variant px-2">
                {{ $current }} / {{ $lastPage }}
            </span>

            {{-- Botão Próximo --}}
            @if($isLast)
                <button
                    type="button"
                    disabled
                    aria-disabled="true"
                    aria-label="Próxima página"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-outline/40 cursor-not-allowed transition-all"
                >
                    <span class="material-symbols-outlined text-lg">chevron_right</span>
                </button>
            @else
                <a
                    href="{{ $nextPageUrl() }}"
                    wire:navigate
                    aria-label="Próxima página"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-outline hover:bg-white transition-all"
                >
                    <span class="material-symbols-outlined text-lg">chevron_right</span>
                </a>
            @endif

        </nav>
    </div>
</div>
