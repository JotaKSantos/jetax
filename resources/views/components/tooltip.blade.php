<div
    x-data="{ show: false }"
    class="relative inline-block"
    @mouseenter="show = true"
    @mouseleave="show = false"
>
    {{-- Trigger: elemento filho (slot padrão) --}}
    <div class="tooltip-trigger">
        {{ $slot }}
    </div>

    {{-- Tooltip --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 whitespace-nowrap bg-slate-900 text-white text-xs px-3 py-1.5 rounded-lg shadow-lg pointer-events-none {{ $tooltipPositionClasses() }}"
        role="tooltip"
    >
        {{ $content }}

        {{-- Seta indicadora --}}
        <span class="absolute w-0 h-0 border-4 {{ $arrowClasses() }}"></span>
    </div>
</div>
