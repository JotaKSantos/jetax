@php
$codeBasico = <<<'BLADE'
<x-jetax-topbar title="Dashboard" />
BLADE;

$codeActions = <<<'BLADE'
<x-jetax-topbar title="Dashboard">
    <x-slot:actions>
        <x-jetax-button size="sm" style="soft" icon="download">Exportar</x-jetax-button>
        <x-jetax-button size="sm" icon="add">Novo</x-jetax-button>
    </x-slot:actions>
</x-jetax-topbar>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <div class="rounded-xl overflow-hidden border border-outline-variant/20 dark:border-white/10">
            <div class="relative h-16 flex items-center justify-between px-4 md:px-6 bg-white/80 dark:bg-[rgb(22,27,42)] backdrop-blur-xl shadow-ambient">
                {{-- Left side --}}
                <div class="flex items-center gap-4">
                    <button type="button" class="flex items-center justify-center w-10 h-10 rounded-lg text-on-surface-variant dark:text-white/60 hover:bg-surface-container-low dark:hover:bg-white/5 transition-colors">
                        <span class="material-symbols-outlined text-[24px]">menu</span>
                    </button>
                    <div class="relative hidden sm:block">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface/40 dark:text-white/40">search</span>
                        <input type="text" placeholder="Pesquisar..." class="bg-surface-container-low dark:bg-[rgb(30,35,55)] border-none rounded-xl pl-10 pr-4 py-2 text-sm w-64 text-on-surface dark:text-[#e2e8f0] placeholder:text-on-surface/40 dark:placeholder:text-white/45">
                    </div>
                </div>
                {{-- Right side --}}
                <div class="flex items-center gap-3">
                    <button type="button" class="p-2 text-on-surface/60 dark:text-white/60 hover:bg-surface-container-low dark:hover:bg-white/5 rounded-lg transition-all">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button type="button" class="p-2 text-on-surface/60 dark:text-white/60 hover:bg-surface-container-low dark:hover:bg-white/5 rounded-lg transition-all">
                        <span class="material-symbols-outlined">dark_mode</span>
                    </button>
                </div>
            </div>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Actions --}}
    <x-jetax-docs-preview-section title="Com Actions" :code="$codeActions">
        <div class="rounded-xl overflow-hidden border border-outline-variant/20 dark:border-white/10">
            <div class="relative h-16 flex items-center justify-between px-4 md:px-6 bg-white/80 dark:bg-[rgb(22,27,42)] backdrop-blur-xl shadow-ambient">
                {{-- Left side --}}
                <div class="flex items-center gap-4">
                    <button type="button" class="flex items-center justify-center w-10 h-10 rounded-lg text-on-surface-variant dark:text-white/60 hover:bg-surface-container-low dark:hover:bg-white/5 transition-colors">
                        <span class="material-symbols-outlined text-[24px]">menu</span>
                    </button>
                    <div class="relative hidden sm:block">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface/40 dark:text-white/40">search</span>
                        <input type="text" placeholder="Pesquisar..." class="bg-surface-container-low dark:bg-[rgb(30,35,55)] border-none rounded-xl pl-10 pr-4 py-2 text-sm w-64 text-on-surface dark:text-[#e2e8f0] placeholder:text-on-surface/40 dark:placeholder:text-white/45">
                    </div>
                </div>
                {{-- Right side with actions --}}
                <div class="flex items-center gap-3">
                    <x-jetax-button size="sm" style="soft" icon="download">Exportar</x-jetax-button>
                    <x-jetax-button size="sm" icon="add">Novo</x-jetax-button>
                </div>
            </div>
        </div>
    </x-jetax-docs-preview-section>

</div>
