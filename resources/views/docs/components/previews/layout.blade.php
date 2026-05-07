@php
$codeBasico = <<<'BLADE'
<x-jetax-layout title="Dashboard">
    <x-jetax-page-header title="Dashboard" />

    {{-- Conteudo da pagina --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-jetax-stats-card label="Usuarios" value="1.250" icon="group" />
        <x-jetax-stats-card label="Vendas" value="R$ 45.000" icon="payments" />
        <x-jetax-stats-card label="Pedidos" value="320" icon="shopping_cart" />
    </div>
</x-jetax-layout>
BLADE;

$codeActions = <<<'BLADE'
<x-jetax-layout title="Relatorios">
    <x-slot:actions>
        <x-jetax-button size="sm" icon="download">Exportar</x-jetax-button>
    </x-slot:actions>

    <x-jetax-page-header title="Relatorios" />
    {{-- Conteudo --}}
</x-jetax-layout>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Uso basico --}}
    <x-jetax-docs-preview-section title="Uso Basico" :code="$codeBasico">
        <div class="w-full flex rounded-xl overflow-hidden border border-outline-variant/20 dark:border-white/10 h-64 text-xs">
            {{-- Sidebar mockup --}}
            <div class="w-40 bg-[#161b2a] flex flex-col p-4 shrink-0">
                <p class="text-white font-bold text-sm mb-1">Jetax</p>
                <p class="text-slate-500 text-[10px] uppercase tracking-wider mb-4">Design System</p>
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-white bg-white/5 px-2 py-1.5 rounded border-l-2 border-[#0D99FF]">
                        <span class="material-symbols-outlined text-sm">dashboard</span>
                        <span class="text-[10px] uppercase">Dashboard</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 px-2 py-1.5">
                        <span class="material-symbols-outlined text-sm">group</span>
                        <span class="text-[10px] uppercase">Usuarios</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 px-2 py-1.5">
                        <span class="material-symbols-outlined text-sm">settings</span>
                        <span class="text-[10px] uppercase">Config</span>
                    </div>
                </div>
            </div>
            {{-- Main area --}}
            <div class="flex-1 flex flex-col bg-surface dark:bg-[rgb(15,18,27)]">
                {{-- Topbar mockup --}}
                <div class="h-10 bg-white/80 dark:bg-[rgb(22,27,42)] border-b border-outline-variant/20 dark:border-white/10 flex items-center justify-between px-4">
                    <span class="material-symbols-outlined text-on-surface-variant/40 text-sm">search</span>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-on-surface-variant/40 text-sm">notifications</span>
                        <span class="material-symbols-outlined text-on-surface-variant/40 text-sm">dark_mode</span>
                        <div class="w-5 h-5 rounded bg-primary-container"></div>
                    </div>
                </div>
                {{-- Content mockup --}}
                <div class="flex-1 p-4">
                    <div class="text-on-surface dark:text-white/80 font-headline text-lg mb-3">Dashboard</div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="h-12 rounded-lg bg-surface-container dark:bg-white/5"></div>
                        <div class="h-12 rounded-lg bg-surface-container dark:bg-white/5"></div>
                        <div class="h-12 rounded-lg bg-surface-container dark:bg-white/5"></div>
                    </div>
                </div>
            </div>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Actions na Topbar --}}
    <x-jetax-docs-preview-section title="Com Actions na Topbar" :code="$codeActions">
        <div class="w-full flex rounded-xl overflow-hidden border border-outline-variant/20 dark:border-white/10 h-48 text-xs">
            {{-- Sidebar mockup --}}
            <div class="w-40 bg-[#161b2a] flex flex-col p-4 shrink-0">
                <p class="text-white font-bold text-sm mb-1">Jetax</p>
                <p class="text-slate-500 text-[10px] uppercase tracking-wider">Design System</p>
            </div>
            {{-- Main area --}}
            <div class="flex-1 flex flex-col bg-surface dark:bg-[rgb(15,18,27)]">
                <div class="h-10 bg-white/80 dark:bg-[rgb(22,27,42)] border-b border-outline-variant/20 dark:border-white/10 flex items-center justify-between px-4">
                    <span class="material-symbols-outlined text-on-surface-variant/40 text-sm">search</span>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-on-surface-variant/40 text-sm">notifications</span>
                        <div class="px-2 py-1 rounded bg-primary-container text-white text-[10px] flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">download</span>
                            Exportar
                        </div>
                    </div>
                </div>
                <div class="flex-1 p-4">
                    <div class="text-on-surface dark:text-white/80 font-headline text-lg">Relatorios</div>
                </div>
            </div>
        </div>
    </x-jetax-docs-preview-section>

</div>
