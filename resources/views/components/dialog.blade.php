<div
    x-data="{ open: false }"
    x-on:dialog-open.window="if ($event.detail && $event.detail.id === '{{ $id }}') open = true"
    x-on:dialog-close.window="if ($event.detail && $event.detail.id === '{{ $id }}') open = false"
    x-on:keydown.escape.window="open = false"
    x-show="open"
    id="{{ $id }}"
    role="alertdialog"
    aria-modal="true"
    aria-labelledby="{{ $id }}-title"
    aria-describedby="{{ $id }}-message"
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
        x-on:click="open = false; $dispatch('dialog-cancelled', { id: '{{ $id }}' })"
        class="absolute inset-0"
        style="background-color: rgba(20, 26, 48, 0.4); backdrop-filter: blur(4px);"
        aria-hidden="true"
    ></div>

    {{-- Container do dialog --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-surface-container-high rounded-xl shadow-2xl relative w-full max-w-sm"
    >
        <div class="p-6 flex flex-col items-center text-center gap-4">
            {{-- Ícone --}}
            <span class="material-symbols-outlined text-5xl {{ $iconClasses() }}">{{ $iconName() }}</span>

            {{-- Título --}}
            @if($title)
                <h2
                    id="{{ $id }}-title"
                    class="text-lg font-semibold text-on-surface"
                >
                    {{ $title }}
                </h2>
            @endif

            {{-- Mensagem --}}
            @if($message)
                <p
                    id="{{ $id }}-message"
                    class="text-sm text-on-surface-variant leading-relaxed"
                >
                    {{ $message }}
                </p>
            @endif

            {{-- Botões --}}
            <div class="flex items-center gap-3 w-full mt-2">
                {{-- Botão cancelar --}}
                <button
                    type="button"
                    x-on:click="open = false; $dispatch('dialog-cancelled', { id: '{{ $id }}' })"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-medium text-on-surface-variant border border-outline-variant hover:bg-surface-container-low transition-all duration-150 hover:scale-[1.02] active:scale-95"
                >
                    {{ $cancelLabel }}
                </button>

                {{-- Botão confirmar --}}
                <button
                    type="button"
                    x-on:click="open = false; $dispatch('dialog-confirmed', { id: '{{ $id }}' })"
                    class="flex-1 {{ $confirmButtonClasses() }}"
                >
                    {{ $confirmLabel }}
                </button>
            </div>
        </div>
    </div>
</div>
