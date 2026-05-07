@php
$codeBasic = <<<'BLADE'
<x-jetax-time name="horario" label="Horario" />
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-time name="horario_off" label="Desabilitado" disabled />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full max-w-sm">
            <x-jetax-time name="horario" label="Horario" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <div class="w-full max-w-sm">
            <x-jetax-time name="horario_off" label="Desabilitado" disabled />
        </div>
    </x-jetax-docs-preview-section>

</div>
