@php
$variants = ['success', 'danger', 'warning', 'info', 'neutral'];
$labels = ['Ativo', 'Inativo', 'Pendente', 'Info', 'Neutro'];

$codeSoft = implode("\n", array_map(fn($v, $l) => '<x-jetax-badge variant="' . $v . '">' . $l . '</x-jetax-badge>', $variants, $labels));

$codeSolid = implode("\n", array_map(fn($v, $l) => '<x-jetax-badge variant="' . $v . '" style="solid">' . $l . '</x-jetax-badge>', $variants, $labels));

$codeStatus = implode("\n", array_map(fn($v, $l) => '<x-jetax-badge variant="' . $v . '" style="status">' . $l . '</x-jetax-badge>', $variants, $labels));

$codeSizes = <<<'BLADE'
<x-jetax-badge variant="success" size="sm">Pequeno</x-jetax-badge>
<x-jetax-badge variant="success" size="md">Medio</x-jetax-badge>
BLADE;

$codeSquare = <<<'BLADE'
<x-jetax-badge variant="success" square>Ativo</x-jetax-badge>
<x-jetax-badge variant="danger" style="solid" square>Inativo</x-jetax-badge>
<x-jetax-badge variant="warning" style="status" square>Pendente</x-jetax-badge>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Estilo Soft --}}
    <x-jetax-docs-preview-section title="Estilo Soft" :code="$codeSoft">
        @foreach($variants as $i => $variant)
            <x-jetax-badge :variant="$variant">{{ $labels[$i] }}</x-jetax-badge>
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Estilo Solid --}}
    <x-jetax-docs-preview-section title="Estilo Solid" :code="$codeSolid">
        @foreach($variants as $i => $variant)
            <x-jetax-badge :variant="$variant" style="solid">{{ $labels[$i] }}</x-jetax-badge>
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Estilo Status --}}
    <x-jetax-docs-preview-section title="Estilo Status" :code="$codeStatus">
        @foreach($variants as $i => $variant)
            <x-jetax-badge :variant="$variant" style="status">{{ $labels[$i] }}</x-jetax-badge>
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Tamanhos --}}
    <x-jetax-docs-preview-section title="Tamanhos" :code="$codeSizes">
        <x-jetax-badge variant="success" size="sm">Pequeno</x-jetax-badge>
        <x-jetax-badge variant="success" size="md">Medio</x-jetax-badge>
    </x-jetax-docs-preview-section>

    {{-- Bordas Quadradas --}}
    <x-jetax-docs-preview-section title="Bordas Quadradas" :code="$codeSquare">
        <x-jetax-badge variant="success" square>Ativo</x-jetax-badge>
        <x-jetax-badge variant="danger" style="solid" square>Inativo</x-jetax-badge>
        <x-jetax-badge variant="warning" style="status" square>Pendente</x-jetax-badge>
    </x-jetax-docs-preview-section>

</div>
