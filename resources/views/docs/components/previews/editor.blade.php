@php
$codeBasic = <<<'BLADE'
<x-jetax-editor placeholder="Digite o conteudo aqui..." />
BLADE;

$codeHeight = <<<'BLADE'
<x-jetax-editor placeholder="Editor com altura customizada..." height="300px" />
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-editor placeholder="Editor desabilitado" disabled />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full max-w-lg">
            <x-jetax-editor placeholder="Digite o conteudo aqui..." />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Altura Customizada --}}
    <x-jetax-docs-preview-section title="Altura Customizada" :code="$codeHeight">
        <div class="w-full max-w-lg">
            <x-jetax-editor placeholder="Editor com altura customizada..." height="300px" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <div class="w-full max-w-lg">
            <x-jetax-editor placeholder="Editor desabilitado" disabled />
        </div>
    </x-jetax-docs-preview-section>

</div>
