@php
$codeBasico = <<<'BLADE'
<x-jetax-collapse>
    <x-slot:trigger>
        <x-jetax-button style="soft">Ver detalhes</x-jetax-button>
    </x-slot:trigger>
    <div class="mt-3 p-4 bg-slate-50 dark:bg-white/5 rounded-lg">
        <p class="text-sm text-slate-600 dark:text-slate-400">Conteúdo oculto que aparece ao clicar no botão.</p>
    </div>
</x-jetax-collapse>
BLADE;

$codeAberto = <<<'BLADE'
<x-jetax-collapse :open="true">
    <x-slot:trigger>
        <x-jetax-button style="soft">Ocultar detalhes</x-jetax-button>
    </x-slot:trigger>
    <div class="mt-3 p-4 bg-slate-50 dark:bg-white/5 rounded-lg">
        <p class="text-sm text-slate-600 dark:text-slate-400">Este conteúdo começa visível e pode ser ocultado.</p>
    </div>
</x-jetax-collapse>
BLADE;

$codeTriggerCustom = <<<'BLADE'
<x-jetax-collapse>
    <x-slot:trigger>
        <span class="text-sm font-semibold text-primary hover:underline cursor-pointer">
            Clique para expandir
        </span>
    </x-slot:trigger>
    <div class="mt-3 p-4 bg-slate-50 dark:bg-white/5 rounded-lg">
        <p class="text-sm text-slate-600 dark:text-slate-400">Qualquer elemento pode ser usado como trigger.</p>
    </div>
</x-jetax-collapse>
BLADE;

$codeSemTrigger = <<<'BLADE'
<x-jetax-collapse>
    <div class="mt-3 p-4 bg-slate-50 dark:bg-white/5 rounded-lg">
        <p class="text-sm text-slate-600 dark:text-slate-400">Sem slot trigger, um botão padrão é renderizado.</p>
    </div>
</x-jetax-collapse>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <x-jetax-collapse>
            <x-slot:trigger>
                <x-jetax-button style="soft">Ver detalhes</x-jetax-button>
            </x-slot:trigger>
            <div class="mt-3 p-4 bg-slate-50 dark:bg-white/5 rounded-lg">
                <p class="text-sm text-slate-600 dark:text-slate-400">Conteúdo oculto que aparece ao clicar no botão.</p>
            </div>
        </x-jetax-collapse>
    </x-jetax-docs-preview-section>

    {{-- Aberto por padrao --}}
    <x-jetax-docs-preview-section title="Aberto por padrao" :code="$codeAberto">
        <x-jetax-collapse :open="true">
            <x-slot:trigger>
                <x-jetax-button style="soft">Ocultar detalhes</x-jetax-button>
            </x-slot:trigger>
            <div class="mt-3 p-4 bg-slate-50 dark:bg-white/5 rounded-lg">
                <p class="text-sm text-slate-600 dark:text-slate-400">Este conteúdo começa visível e pode ser ocultado.</p>
            </div>
        </x-jetax-collapse>
    </x-jetax-docs-preview-section>

    {{-- Trigger customizado --}}
    <x-jetax-docs-preview-section title="Trigger customizado" :code="$codeTriggerCustom">
        <x-jetax-collapse>
            <x-slot:trigger>
                <span class="text-sm font-semibold text-primary hover:underline cursor-pointer">
                    Clique para expandir
                </span>
            </x-slot:trigger>
            <div class="mt-3 p-4 bg-slate-50 dark:bg-white/5 rounded-lg">
                <p class="text-sm text-slate-600 dark:text-slate-400">Qualquer elemento pode ser usado como trigger.</p>
            </div>
        </x-jetax-collapse>
    </x-jetax-docs-preview-section>

    {{-- Sem trigger (botao padrao) --}}
    <x-jetax-docs-preview-section title="Sem trigger (botao padrao)" :code="$codeSemTrigger">
        <x-jetax-collapse>
            <div class="mt-3 p-4 bg-slate-50 dark:bg-white/5 rounded-lg">
                <p class="text-sm text-slate-600 dark:text-slate-400">Sem slot trigger, um botão padrão é renderizado.</p>
            </div>
        </x-jetax-collapse>
    </x-jetax-docs-preview-section>

</div>
