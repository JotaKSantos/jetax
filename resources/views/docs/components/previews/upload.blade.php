@php
$codeBasic = <<<'BLADE'
<x-jetax-upload />
BLADE;

$codeMultiple = <<<'BLADE'
<x-jetax-upload :multiple="true" />
BLADE;

$codeAccept = <<<'BLADE'
<x-jetax-upload accept="image/*" :max-size="5" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full max-w-md">
            <x-jetax-upload />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Multiplos Arquivos --}}
    <x-jetax-docs-preview-section title="Multiplos Arquivos" :code="$codeMultiple">
        <div class="w-full max-w-md">
            <x-jetax-upload :multiple="true" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Tipos Aceitos --}}
    <x-jetax-docs-preview-section title="Apenas Imagens (max 5MB)" :code="$codeAccept">
        <div class="w-full max-w-md">
            <x-jetax-upload accept="image/*" :max-size="5" />
        </div>
    </x-jetax-docs-preview-section>

</div>
