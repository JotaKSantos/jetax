@php
$codeBasico = <<<'BLADE'
<x-jetax-sidebar>
    {{-- Navegacao automatica via config('jetax.navigation.main') --}}
</x-jetax-sidebar>
BLADE;

$codeNavCustomizado = <<<'BLADE'
<x-jetax-sidebar>
    <x-slot:nav>
        <a href="/dashboard" class="flex items-center px-6 py-3 text-white bg-white/5">
            <span class="material-symbols-outlined mr-3">dashboard</span>
            <span class="text-[11px] font-medium uppercase">Dashboard</span>
        </a>
        <a href="/usuarios" class="flex items-center px-6 py-3 text-slate-400 hover:text-white">
            <span class="material-symbols-outlined mr-3">group</span>
            <span class="text-[11px] font-medium uppercase">Usuarios</span>
        </a>
        <a href="/config" class="flex items-center px-6 py-3 text-slate-400 hover:text-white">
            <span class="material-symbols-outlined mr-3">settings</span>
            <span class="text-[11px] font-medium uppercase">Configuracoes</span>
        </a>
    </x-slot:nav>
</x-jetax-sidebar>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <div class="w-56 rounded-xl overflow-hidden border border-outline-variant/20 dark:border-white/10">
            <div class="bg-[#161b2a] p-4 h-72 flex flex-col text-xs">
                {{-- Branding --}}
                <div class="mb-4">
                    <p class="text-white font-bold text-sm">Jetax</p>
                    <p class="text-slate-500 text-[10px] uppercase tracking-wider font-medium">Design System</p>
                </div>

                {{-- Grupo --}}
                <p class="text-slate-500 text-[9px] font-bold tracking-widest uppercase mb-2">Principal</p>

                {{-- Nav items --}}
                <div class="space-y-1">
                    <div class="flex items-center gap-2 text-white bg-white/5 px-3 py-2 rounded relative">
                        <div class="absolute left-0 w-1 h-5 bg-[#0D99FF] rounded-r-full"></div>
                        <span class="material-symbols-outlined text-sm">dashboard</span>
                        <span class="text-[10px] font-medium uppercase tracking-wider">Dashboard</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 px-3 py-2">
                        <span class="material-symbols-outlined text-sm">group</span>
                        <span class="text-[10px] font-medium uppercase tracking-wider">Usuarios</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 px-3 py-2">
                        <span class="material-symbols-outlined text-sm">inventory_2</span>
                        <span class="text-[10px] font-medium uppercase tracking-wider">Produtos</span>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="mt-auto pt-3 border-t border-white/5">
                    <div class="flex items-center gap-2 text-slate-400 px-3 py-2">
                        <span class="material-symbols-outlined text-sm">settings</span>
                        <span class="text-[10px] font-medium uppercase tracking-wider">Config</span>
                    </div>
                </div>
            </div>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Nav Customizado --}}
    <x-jetax-docs-preview-section title="Com Nav Customizado" :code="$codeNavCustomizado">
        <div class="w-56 rounded-xl overflow-hidden border border-outline-variant/20 dark:border-white/10">
            <div class="bg-[#161b2a] p-4 h-56 flex flex-col text-xs">
                {{-- Branding --}}
                <div class="mb-4">
                    <p class="text-white font-bold text-sm">Jetax</p>
                    <p class="text-slate-500 text-[10px] uppercase tracking-wider font-medium">Design System</p>
                </div>

                {{-- Nav items customizados --}}
                <div class="space-y-1">
                    <div class="flex items-center gap-2 text-white bg-white/5 px-3 py-2 rounded">
                        <span class="material-symbols-outlined text-sm">dashboard</span>
                        <span class="text-[10px] font-medium uppercase tracking-wider">Dashboard</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 px-3 py-2">
                        <span class="material-symbols-outlined text-sm">group</span>
                        <span class="text-[10px] font-medium uppercase tracking-wider">Usuarios</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 px-3 py-2">
                        <span class="material-symbols-outlined text-sm">settings</span>
                        <span class="text-[10px] font-medium uppercase tracking-wider">Configuracoes</span>
                    </div>
                </div>
            </div>
        </div>
    </x-jetax-docs-preview-section>

</div>
