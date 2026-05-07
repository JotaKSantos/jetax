@php
$codeBasico = <<<'BLADE'
<x-jetax-dismissable>
    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg text-sm text-blue-700 dark:text-blue-300">
        Esta é uma notificação que pode ser fechada clicando no botão ×.
    </div>
</x-jetax-dismissable>
BLADE;

$codePersist = <<<'BLADE'
<x-jetax-dismissable persist-key="docs-demo-persist">
    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg text-sm text-amber-700 dark:text-amber-300">
        Este aviso persiste no localStorage — ao fechar e recarregar a página, permanece oculto.
    </div>
</x-jetax-dismissable>
BLADE;

$codeTrigger = <<<'BLADE'
<x-jetax-dismissable>
    <x-slot:dismiss-trigger>
        <button class="absolute top-2 right-2 text-xs text-red-500 hover:text-red-700 font-semibold">
            Remover
        </button>
    </x-slot:dismiss-trigger>
    <div class="p-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-lg text-sm text-slate-600 dark:text-slate-400">
        Conteúdo com trigger de fechamento personalizado.
    </div>
</x-jetax-dismissable>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <x-jetax-dismissable>
            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg text-sm text-blue-700 dark:text-blue-300">
                Esta é uma notificação que pode ser fechada clicando no botão ×.
            </div>
        </x-jetax-dismissable>
    </x-jetax-docs-preview-section>

    {{-- Persistencia --}}
    <x-jetax-docs-preview-section title="Persistencia (localStorage)" :code="$codePersist">
        <x-jetax-dismissable persist-key="docs-demo-persist">
            <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg text-sm text-amber-700 dark:text-amber-300">
                Este aviso persiste no localStorage — ao fechar e recarregar a página, permanece oculto.
            </div>
        </x-jetax-dismissable>
    </x-jetax-docs-preview-section>

    {{-- Trigger customizado --}}
    <x-jetax-docs-preview-section title="Trigger Customizado" :code="$codeTrigger">
        <x-jetax-dismissable>
            <x-slot:dismiss-trigger>
                <button class="absolute top-2 right-2 text-xs text-red-500 hover:text-red-700 font-semibold">
                    Remover
                </button>
            </x-slot:dismiss-trigger>
            <div class="p-4 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-lg text-sm text-slate-600 dark:text-slate-400">
                Conteúdo com trigger de fechamento personalizado.
            </div>
        </x-jetax-dismissable>
    </x-jetax-docs-preview-section>

</div>
