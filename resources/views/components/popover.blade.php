<div
    x-data="{ open: false }"
    class="relative inline-block"
    @keydown.escape.window="open = false"
>
    {{-- Trigger: elemento filho (slot padrão) --}}
    <div
        class="popover-trigger"
        @click="open = !open"
    >
        {{ $slot }}
    </div>

    {{-- Popover --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click.outside="open = false"
        class="absolute z-50 bg-surface-container-high rounded-xl shadow-2xl border border-outline-variant p-4 min-w-max {{ $popoverPositionClasses() }}"
        role="dialog"
        aria-modal="true"
        style="display: none;"
    >
        {{-- Seta indicadora --}}
        <span class="absolute w-0 h-0 border-4 popover-arrow {{ $arrowClasses() }}"></span>

        {{-- Conteúdo rico --}}
        {{ $content }}
    </div>
</div>
