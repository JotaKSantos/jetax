<div
    x-data="{ open: false }"
    x-on:modal-open.window="if ($event.detail === '{{ $id }}' || ($event.detail && $event.detail.id === '{{ $id }}')) open = true"
    x-on:modal-close.window="if ($event.detail === '{{ $id }}' || ($event.detail && $event.detail.id === '{{ $id }}')) open = false"
    x-on:keydown.escape.window="open = false"
    x-show="open"
    id="{{ $id }}"
    role="dialog"
    aria-modal="true"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="open = false"
        class="modal-overlay absolute inset-0"
        style="background-color: rgba(20, 26, 48, 0.4); backdrop-filter: blur(4px);"
        aria-hidden="true"
    ></div>

    {{-- Container do modal --}}
    <div
        x-show="open"
        x-trap.noscroll="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="{{ $containerClasses() }} {{ $sizeClasses() }} relative w-full"
    >
        {{-- Header: renderizado sempre que há conteúdo de header OU quando é high-risk --}}
        @php
            $hasHeaderContent = isset($header) && (is_object($header) ? $header->isNotEmpty() : (trim((string) $header) !== ''));
            $showHeader = $hasHeaderContent || $highRisk;
        @endphp

        @if($showHeader)
            <div class="{{ $headerClasses() }}">
                <div class="flex-1">
                    @if($hasHeaderContent)
                        {{ $header }}
                    @endif
                </div>
                <button
                    type="button"
                    x-on:click="open = false"
                    class="ml-4 p-1.5 rounded-lg hover:bg-black/5 transition-colors hover:scale-[1.02] active:scale-95"
                    aria-label="Fechar modal"
                >
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
        @endif

        {{-- Corpo --}}
        <div class="p-6 text-sm text-slate-600 leading-relaxed">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        @isset($footer)
            @php $hasFooter = is_object($footer) ? $footer->isNotEmpty() : (trim((string) $footer) !== ''); @endphp
            @if($hasFooter)
                <div class="px-6 py-4 bg-slate-50/50 flex justify-end gap-3">
                    {{ $footer }}
                </div>
            @endif
        @endisset
    </div>
</div>
