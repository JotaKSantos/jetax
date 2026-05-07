@php
$codeBasic = <<<'BLADE'
<x-jetax-checkbox label="Aceito os termos de uso" />
<x-jetax-checkbox label="Receber notificacoes por e-mail" />
<x-jetax-checkbox label="Manter sessao ativa" :checked="true" />
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-checkbox label="Opcao desabilitada" disabled />
<x-jetax-checkbox label="Marcado e desabilitado" :checked="true" disabled />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-checkbox label="Aceito os termos de uso" />
        <x-jetax-checkbox label="Receber notificacoes por e-mail" />
        <x-jetax-checkbox label="Manter sessao ativa" :checked="true" />
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <x-jetax-checkbox label="Opcao desabilitada" disabled />
        <x-jetax-checkbox label="Marcado e desabilitado" :checked="true" disabled />
    </x-jetax-docs-preview-section>

</div>
