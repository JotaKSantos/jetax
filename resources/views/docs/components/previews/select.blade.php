@php
$codeBasic = <<<'BLADE'
<x-jetax-select
    name="estado"
    label="Estado"
    placeholder="Selecione um estado"
    :options="['SP' => 'Sao Paulo', 'RJ' => 'Rio de Janeiro', 'MG' => 'Minas Gerais']"
/>
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-select
    name="estado_off"
    label="Desabilitado"
    placeholder="Selecione..."
    :options="['SP' => 'Sao Paulo', 'RJ' => 'Rio de Janeiro']"
    disabled
/>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full max-w-sm">
            <x-jetax-select
                name="estado"
                label="Estado"
                placeholder="Selecione um estado"
                :options="['SP' => 'Sao Paulo', 'RJ' => 'Rio de Janeiro', 'MG' => 'Minas Gerais']"
            />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <div class="w-full max-w-sm">
            <x-jetax-select
                name="estado_off"
                label="Desabilitado"
                placeholder="Selecione..."
                :options="['SP' => 'Sao Paulo', 'RJ' => 'Rio de Janeiro']"
                disabled
            />
        </div>
    </x-jetax-docs-preview-section>

</div>
