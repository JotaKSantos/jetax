@php
$codeBasic = <<<'BLADE'
<x-jetax-range :min="0" :max="100" :value="50" />
BLADE;

$codeCustom = <<<'BLADE'
<x-jetax-range :min="0" :max="1000" :step="50" :value="250" />
BLADE;

$codeShowValue = <<<'BLADE'
<x-jetax-range :min="0" :max="100" :value="75" :show-value="true" />
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-range :min="0" :max="100" :value="30" disabled />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full max-w-sm">
            <x-jetax-range :min="0" :max="100" :value="50" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Min/Max/Step Customizado --}}
    <x-jetax-docs-preview-section title="Min/Max/Step Customizado" :code="$codeCustom">
        <div class="w-full max-w-sm">
            <x-jetax-range :min="0" :max="1000" :step="50" :value="250" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Valor Visivel --}}
    <x-jetax-docs-preview-section title="Com Valor Visivel" :code="$codeShowValue">
        <div class="w-full max-w-sm">
            <x-jetax-range :min="0" :max="100" :value="75" :show-value="true" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <div class="w-full max-w-sm">
            <x-jetax-range :min="0" :max="100" :value="30" disabled />
        </div>
    </x-jetax-docs-preview-section>

</div>
