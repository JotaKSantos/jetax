<div class="rounded-xl border border-slate-200 dark:border-white/10" x-data="{ showCode: false }">
    <div class="px-6 py-4 border-b border-slate-200 dark:border-white/10 flex items-center justify-between bg-slate-50 dark:bg-white/[0.03] rounded-t-xl">
        <span class="font-headline font-bold text-primary text-sm">{{ $title }}</span>
        <div class="flex items-center gap-2">
            <button
                @click="showCode = !showCode"
                class="text-xs text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 flex items-center gap-1 transition-colors"
            >
                <span class="material-symbols-outlined text-sm" x-text="showCode ? 'visibility_off' : 'code'"></span>
                <span x-text="showCode ? 'Ocultar Codigo' : 'Ver Codigo'"></span>
            </button>
            <button
                x-show="showCode"
                x-cloak
                @click="
                    navigator.clipboard.writeText($refs.code.textContent).then(() => {
                        $el.querySelector('span:last-child').textContent = 'Copiado!';
                        $el.classList.add('text-green-600');
                        setTimeout(() => {
                            $el.querySelector('span:last-child').textContent = 'Copiar';
                            $el.classList.remove('text-green-600');
                        }, 2000);
                    })
                "
                class="text-xs text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 flex items-center gap-1 transition-colors"
            >
                <span class="material-symbols-outlined text-sm">content_copy</span>
                <span>Copiar</span>
            </button>
        </div>
    </div>

    <div class="px-6 py-6 flex flex-wrap items-start gap-4">
        {{ $slot }}
    </div>

    <div x-show="showCode" x-cloak x-transition.opacity>
        <pre class="bg-gray-950 text-gray-100 px-6 py-4 text-sm overflow-x-auto border-t border-slate-200 dark:border-white/10 rounded-b-xl"><code x-ref="code">{{ $code }}</code></pre>
    </div>
</div>
