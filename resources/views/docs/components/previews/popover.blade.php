@php
$codeBasic = <<<'BLADE'
<x-jetax-popover>
    <x-jetax-button icon="info" style="soft">Mais informacoes</x-jetax-button>
    <x-slot:content>
        <p>Detalhes adicionais sobre o item.</p>
    </x-slot:content>
</x-jetax-popover>
BLADE;

$codePositions = <<<'BLADE'
<x-jetax-popover position="top">
    <x-jetax-button>Top</x-jetax-button>
    <x-slot:content>
        <p>Popover no topo.</p>
    </x-slot:content>
</x-jetax-popover>

<x-jetax-popover position="bottom">
    <x-jetax-button>Bottom</x-jetax-button>
    <x-slot:content>
        <p>Popover embaixo.</p>
    </x-slot:content>
</x-jetax-popover>

<x-jetax-popover position="left">
    <x-jetax-button>Left</x-jetax-button>
    <x-slot:content>
        <p>Popover a esquerda.</p>
    </x-slot:content>
</x-jetax-popover>

<x-jetax-popover position="right">
    <x-jetax-button>Right</x-jetax-button>
    <x-slot:content>
        <p>Popover a direita.</p>
    </x-slot:content>
</x-jetax-popover>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-popover>
            <x-jetax-button icon="info" style="soft">Mais informacoes</x-jetax-button>
            <x-slot:content>
                <p>Detalhes adicionais sobre o item.</p>
            </x-slot:content>
        </x-jetax-popover>
    </x-jetax-docs-preview-section>

    {{-- Posicoes --}}
    <x-jetax-docs-preview-section title="Posicoes" :code="$codePositions">
        <div class="flex flex-wrap items-center justify-center gap-6 py-16">
            <x-jetax-popover position="top">
                <x-jetax-button>Top</x-jetax-button>
                <x-slot:content>
                    <p>Popover no topo.</p>
                </x-slot:content>
            </x-jetax-popover>

            <x-jetax-popover position="bottom">
                <x-jetax-button>Bottom</x-jetax-button>
                <x-slot:content>
                    <p>Popover embaixo.</p>
                </x-slot:content>
            </x-jetax-popover>

            <x-jetax-popover position="left">
                <x-jetax-button>Left</x-jetax-button>
                <x-slot:content>
                    <p>Popover a esquerda.</p>
                </x-slot:content>
            </x-jetax-popover>

            <x-jetax-popover position="right">
                <x-jetax-button>Right</x-jetax-button>
                <x-slot:content>
                    <p>Popover a direita.</p>
                </x-slot:content>
            </x-jetax-popover>
        </div>
    </x-jetax-docs-preview-section>

</div>
