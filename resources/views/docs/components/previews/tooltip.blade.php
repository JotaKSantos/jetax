@php
$codeBasic = <<<'BLADE'
<x-jetax-tooltip content="Clique para salvar">
    <x-jetax-button icon="save">Salvar</x-jetax-button>
</x-jetax-tooltip>
BLADE;

$codePositions = <<<'BLADE'
<x-jetax-tooltip content="Tooltip no topo" position="top">
    <x-jetax-button>Top</x-jetax-button>
</x-jetax-tooltip>

<x-jetax-tooltip content="Tooltip embaixo" position="bottom">
    <x-jetax-button>Bottom</x-jetax-button>
</x-jetax-tooltip>

<x-jetax-tooltip content="Tooltip a esquerda" position="left">
    <x-jetax-button>Left</x-jetax-button>
</x-jetax-tooltip>

<x-jetax-tooltip content="Tooltip a direita" position="right">
    <x-jetax-button>Right</x-jetax-button>
</x-jetax-tooltip>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-tooltip content="Clique para salvar">
            <x-jetax-button icon="save">Salvar</x-jetax-button>
        </x-jetax-tooltip>
    </x-jetax-docs-preview-section>

    {{-- Posicoes --}}
    <x-jetax-docs-preview-section title="Posicoes" :code="$codePositions">
        <div class="flex flex-wrap items-center justify-center gap-6 py-10">
            <x-jetax-tooltip content="Tooltip no topo" position="top">
                <x-jetax-button>Top</x-jetax-button>
            </x-jetax-tooltip>

            <x-jetax-tooltip content="Tooltip embaixo" position="bottom">
                <x-jetax-button>Bottom</x-jetax-button>
            </x-jetax-tooltip>

            <x-jetax-tooltip content="Tooltip a esquerda" position="left">
                <x-jetax-button>Left</x-jetax-button>
            </x-jetax-tooltip>

            <x-jetax-tooltip content="Tooltip a direita" position="right">
                <x-jetax-button>Right</x-jetax-button>
            </x-jetax-tooltip>
        </div>
    </x-jetax-docs-preview-section>

</div>
