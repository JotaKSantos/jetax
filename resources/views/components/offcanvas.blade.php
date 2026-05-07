<div
    x-data="{ open: false }"
    x-on:offcanvas-open.window="if ($event.detail === '{{ $id }}' || ($event.detail && $event.detail.id === '{{ $id }}')) open = true"
    x-on:offcanvas-close.window="if ($event.detail === '{{ $id }}' || ($event.detail && $event.detail.id === '{{ $id }}')) open = false"
    x-on:keydown.escape.window="open = false"
    x-show="open"
    id="{{ $id }}"
    role="dialog"
    aria-modal="true"
    class="fixed inset-0 z-50"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="open = false"
        class="offcanvas-backdrop absolute inset-0 bg-black/40"
        aria-hidden="true"
    ></div>

    {{-- Painel --}}
    <div
        x-show="open"
        x-trap.noscroll="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="{{ $enterStartClasses() }} opacity-0"
        x-transition:enter-end="translate-x-0 translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0 translate-y-0 opacity-100"
        x-transition:leave-end="{{ $enterStartClasses() }} opacity-0"
        class="{{ $panelClasses() }}"
    >
        {{-- Header --}}
        @php
            $hasHeaderContent = isset($header) && (is_object($header) ? $header->isNotEmpty() : (trim((string) $header) !== ''));
        @endphp

        <div class="p-4 border-b border-slate-100 flex items-center justify-between shrink-0">
            <div class="flex-1 font-bold text-sm uppercase tracking-wider text-on-surface">
                @if($hasHeaderContent)
                    {{ $header }}
                @endif
            </div>
            <button
                type="button"
                x-on:click="open = false"
                class="ml-4 p-1.5 rounded-lg hover:bg-black/5 transition-colors hover:scale-[1.02] active:scale-95"
                aria-label="Fechar painel"
            >
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        {{-- Corpo --}}
        <div class="flex-1 overflow-y-auto p-4">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        @isset($footer)
            @php $hasFooter = is_object($footer) ? $footer->isNotEmpty() : (trim((string) $footer) !== ''); @endphp
            @if($hasFooter)
                <div class="p-6 bg-surface shrink-0">
                    {{ $footer }}
                </div>
            @endif
        @endisset
    </div>
</div>
