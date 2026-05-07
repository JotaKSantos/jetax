@php
$codeBasic = <<<'BLADE'
<x-jetax-toggle label="Notificacoes ativas" />
<x-jetax-toggle label="Modo escuro" :checked="true" />
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-toggle label="Opcao desabilitada" disabled />
<x-jetax-toggle label="Ativo e desabilitado" :checked="true" disabled />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-toggle label="Notificacoes ativas" />
        <x-jetax-toggle label="Modo escuro" :checked="true" />
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <x-jetax-toggle label="Opcao desabilitada" disabled />
        <x-jetax-toggle label="Ativo e desabilitado" :checked="true" disabled />
    </x-jetax-docs-preview-section>

</div>
