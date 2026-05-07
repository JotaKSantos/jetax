@php
$codeBasic = <<<'BLADE'
<x-jetax-color />
BLADE;

$codeDefault = <<<'BLADE'
<x-jetax-color default-color="#0061a5" />
<x-jetax-color default-color="#e74c3c" />
<x-jetax-color default-color="#2ecc71" />
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-color default-color="#0061a5" disabled />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-color />
    </x-jetax-docs-preview-section>

    {{-- Com Valor Padrao --}}
    <x-jetax-docs-preview-section title="Com Valor Padrao" :code="$codeDefault">
        <x-jetax-color default-color="#0061a5" />
        <x-jetax-color default-color="#e74c3c" />
        <x-jetax-color default-color="#2ecc71" />
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <x-jetax-color default-color="#0061a5" disabled />
    </x-jetax-docs-preview-section>

</div>
