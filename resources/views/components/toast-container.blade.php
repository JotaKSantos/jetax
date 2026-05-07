<div
    x-data="{
        toasts: [],
        add(toast) {
            const id = Date.now();
            this.toasts.push({ id, ...toast });
            setTimeout(() => this.remove(id), toast.duration || 4000);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    @toast.window="add($event.detail)"
    x-on:toast.window="add($event.detail)"
    class="fixed z-50 {{ $positionClasses() }} space-y-3"
    aria-live="polite"
    aria-label="Notificações"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            :class="{
                'bg-emerald-600 text-white': toast.variant === 'success',
                'bg-red-600 text-white': toast.variant === 'error',
                'bg-amber-500 text-white': toast.variant === 'warning',
                'bg-blue-600 text-white': !toast.variant || toast.variant === 'info'
            }"
            class="flex items-center gap-3 py-3 px-5 rounded-xl shadow-2xl min-w-72 max-w-sm"
            role="alert"
        >
            {{-- Ícone por variante --}}
            <span class="material-symbols-outlined text-xl flex-shrink-0" x-text="
                toast.variant === 'success' ? 'check_circle' :
                toast.variant === 'error' ? 'error' :
                toast.variant === 'warning' ? 'warning' :
                'info'
            "></span>

            {{-- Mensagem --}}
            <span class="text-sm font-medium flex-1" x-text="toast.message"></span>

            {{-- Botão de fechar --}}
            <button
                type="button"
                @click="remove(toast.id)"
                class="p-1 hover:bg-white/20 rounded transition-colors flex-shrink-0"
                aria-label="Fechar notificação"
            >
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    </template>
</div>
