@php
$codeBasico = <<<'BLADE'
<x-jetax-rating />
BLADE;

$codeValor = <<<'BLADE'
<x-jetax-rating :value="3" />
BLADE;

$codeTamanhos = <<<'BLADE'
<div class="flex flex-col gap-3">
    <x-jetax-rating :value="3" size="sm" />
    <x-jetax-rating :value="3" size="md" />
    <x-jetax-rating :value="3" size="lg" />
</div>
BLADE;

$codeReadonly = <<<'BLADE'
<div class="flex flex-col gap-3">
    <x-jetax-rating :value="3.5" :readonly="true" />
    <x-jetax-rating :value="4.2" :readonly="true" />
</div>
BLADE;

$codeForm = <<<'BLADE'
<x-jetax-rating :value="0" name="rating" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <x-jetax-rating />
    </x-jetax-docs-preview-section>

    {{-- Valor inicial --}}
    <x-jetax-docs-preview-section title="Valor Inicial" :code="$codeValor">
        <x-jetax-rating :value="3" />
    </x-jetax-docs-preview-section>

    {{-- Tamanhos --}}
    <x-jetax-docs-preview-section title="Tamanhos" :code="$codeTamanhos">
        <div class="flex flex-col gap-3">
            <x-jetax-rating :value="3" size="sm" />
            <x-jetax-rating :value="3" size="md" />
            <x-jetax-rating :value="3" size="lg" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Somente leitura --}}
    <x-jetax-docs-preview-section title="Somente Leitura" :code="$codeReadonly">
        <div class="flex flex-col gap-3">
            <x-jetax-rating :value="3.5" :readonly="true" />
            <x-jetax-rating :value="4.2" :readonly="true" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com nome (formulario) --}}
    <x-jetax-docs-preview-section title="Com Nome (Formulario)" :code="$codeForm">
        <x-jetax-rating :value="0" name="rating" />
    </x-jetax-docs-preview-section>

</div>
