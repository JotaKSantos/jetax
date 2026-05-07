<div
    class="relative inline-block"
    x-data="{ open: false }"
    @click.outside="open = false"
    @keydown.escape.window="open = false"
>
    {{-- Trigger --}}
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    {{-- Menu --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 mt-2 w-56 bg-white rounded-xl architect-shadow ring-1 ring-black/5 overflow-hidden {{ $menuPositionClasses() }}"
        style="display: none;"
    >
        <div class="py-2">
            {{ $slot }}
        </div>
    </div>
</div>
