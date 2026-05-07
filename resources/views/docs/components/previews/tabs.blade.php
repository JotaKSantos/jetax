@php
$codeUnderline = <<<'BLADE'
<x-jetax-tabs :tabs="[
    ['name' => 'info', 'label' => 'Informacoes'],
    ['name' => 'config', 'label' => 'Configuracoes'],
    ['name' => 'logs', 'label' => 'Historico'],
]" variant="underline">
    <x-slot:info>Conteudo da aba Informacoes.</x-slot:info>
    <x-slot:config>Conteudo da aba Configuracoes.</x-slot:config>
    <x-slot:logs>Conteudo da aba Historico.</x-slot:logs>
</x-jetax-tabs>
BLADE;

$codePill = <<<'BLADE'
<x-jetax-tabs :tabs="[
    ['name' => 'geral', 'label' => 'Geral'],
    ['name' => 'seguranca', 'label' => 'Seguranca'],
    ['name' => 'notificacoes', 'label' => 'Notificacoes'],
]" variant="pill">
    <x-slot:geral>Configuracoes gerais da conta.</x-slot:geral>
    <x-slot:seguranca>Opcoes de seguranca e autenticacao.</x-slot:seguranca>
    <x-slot:notificacoes>Preferencias de notificacao.</x-slot:notificacoes>
</x-jetax-tabs>
BLADE;

$codeCount = <<<'BLADE'
<x-jetax-tabs :tabs="[
    ['name' => 'todos', 'label' => 'Todos', 'count' => 48],
    ['name' => 'ativos', 'label' => 'Ativos', 'count' => 32],
    ['name' => 'inativos', 'label' => 'Inativos', 'count' => 16],
]" variant="underline">
    <x-slot:todos>Lista com todos os registros.</x-slot:todos>
    <x-slot:ativos>Apenas registros ativos.</x-slot:ativos>
    <x-slot:inativos>Apenas registros inativos.</x-slot:inativos>
</x-jetax-tabs>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Underline --}}
    <x-jetax-docs-preview-section title="Underline (padrao)" :code="$codeUnderline">
        <div class="w-full">
            <x-jetax-tabs :tabs="[
                ['name' => 'info', 'label' => 'Informacoes'],
                ['name' => 'config', 'label' => 'Configuracoes'],
                ['name' => 'logs', 'label' => 'Historico'],
            ]" variant="underline">
                <x-slot:info><div class="py-4 text-sm text-slate-600">Conteudo da aba Informacoes.</div></x-slot:info>
                <x-slot:config><div class="py-4 text-sm text-slate-600">Conteudo da aba Configuracoes.</div></x-slot:config>
                <x-slot:logs><div class="py-4 text-sm text-slate-600">Conteudo da aba Historico.</div></x-slot:logs>
            </x-jetax-tabs>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Pill --}}
    <x-jetax-docs-preview-section title="Pill" :code="$codePill">
        <div class="w-full">
            <x-jetax-tabs :tabs="[
                ['name' => 'geral', 'label' => 'Geral'],
                ['name' => 'seguranca', 'label' => 'Seguranca'],
                ['name' => 'notificacoes', 'label' => 'Notificacoes'],
            ]" variant="pill">
                <x-slot:geral><div class="py-4 text-sm text-slate-600">Configuracoes gerais da conta.</div></x-slot:geral>
                <x-slot:seguranca><div class="py-4 text-sm text-slate-600">Opcoes de seguranca e autenticacao.</div></x-slot:seguranca>
                <x-slot:notificacoes><div class="py-4 text-sm text-slate-600">Preferencias de notificacao.</div></x-slot:notificacoes>
            </x-jetax-tabs>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com contadores --}}
    <x-jetax-docs-preview-section title="Com contadores" :code="$codeCount">
        <div class="w-full">
            <x-jetax-tabs :tabs="[
                ['name' => 'todos', 'label' => 'Todos', 'count' => 48],
                ['name' => 'ativos', 'label' => 'Ativos', 'count' => 32],
                ['name' => 'inativos', 'label' => 'Inativos', 'count' => 16],
            ]" variant="underline">
                <x-slot:todos><div class="py-4 text-sm text-slate-600">Lista com todos os registros.</div></x-slot:todos>
                <x-slot:ativos><div class="py-4 text-sm text-slate-600">Apenas registros ativos.</div></x-slot:ativos>
                <x-slot:inativos><div class="py-4 text-sm text-slate-600">Apenas registros inativos.</div></x-slot:inativos>
            </x-jetax-tabs>
        </div>
    </x-jetax-docs-preview-section>

</div>
