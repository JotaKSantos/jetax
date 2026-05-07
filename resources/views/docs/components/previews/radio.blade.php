@php
$codeGroup = <<<'BLADE'
<x-jetax-radio name="plano" value="basico" label="Basico" />
<x-jetax-radio name="plano" value="pro" label="Pro" />
<x-jetax-radio name="plano" value="enterprise" label="Enterprise" />
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-radio name="status" value="ativo" label="Ativo" disabled />
<x-jetax-radio name="status" value="inativo" label="Inativo" disabled />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Grupo Basico --}}
    <x-jetax-docs-preview-section title="Grupo de Opcoes" :code="$codeGroup">
        <x-jetax-radio name="plano" value="basico" label="Basico" />
        <x-jetax-radio name="plano" value="pro" label="Pro" />
        <x-jetax-radio name="plano" value="enterprise" label="Enterprise" />
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <x-jetax-radio name="status" value="ativo" label="Ativo" disabled />
        <x-jetax-radio name="status" value="inativo" label="Inativo" disabled />
    </x-jetax-docs-preview-section>

</div>
