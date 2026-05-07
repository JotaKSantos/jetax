@php
$codeBasic = <<<'BLADE'
<x-jetax-button &#64;click="$dispatch('offcanvas-open', 'meu-offcanvas')">
    Abrir Painel
</x-jetax-button>

<x-jetax-offcanvas id="meu-offcanvas">
    <x-slot:header>Filtros</x-slot:header>
    <p>Conteudo do painel lateral.</p>
</x-jetax-offcanvas>
BLADE;

$codePositions = <<<'BLADE'
<x-jetax-offcanvas id="offcanvas-right" position="right">
    <x-slot:header>Direita</x-slot:header>
    <p>Painel a direita.</p>
</x-jetax-offcanvas>

<x-jetax-offcanvas id="offcanvas-left" position="left">
    <x-slot:header>Esquerda</x-slot:header>
    <p>Painel a esquerda.</p>
</x-jetax-offcanvas>

<x-jetax-offcanvas id="offcanvas-top" position="top">
    <x-slot:header>Topo</x-slot:header>
    <p>Painel no topo.</p>
</x-jetax-offcanvas>

<x-jetax-offcanvas id="offcanvas-bottom" position="bottom">
    <x-slot:header>Inferior</x-slot:header>
    <p>Painel inferior.</p>
</x-jetax-offcanvas>
BLADE;

$codeSlots = <<<'BLADE'
<x-jetax-offcanvas id="offcanvas-slots">
    <x-slot:header>Titulo via Header</x-slot:header>
    <p>Conteudo do painel.</p>
    <x-slot:footer>
        <x-jetax-button style="soft" &#64;click="$dispatch('offcanvas-close', 'offcanvas-slots')">
            Cancelar
        </x-jetax-button>
        <x-jetax-button color="primary">Aplicar</x-jetax-button>
    </x-slot:footer>
</x-jetax-offcanvas>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-button @click="$dispatch('offcanvas-open', 'demo-offcanvas-basic')">
            Abrir Painel
        </x-jetax-button>

        <x-jetax-offcanvas id="demo-offcanvas-basic">
            <x-slot:header>Filtros</x-slot:header>
            <p>Conteudo do painel lateral.</p>
        </x-jetax-offcanvas>
    </x-jetax-docs-preview-section>

    {{-- Posicoes --}}
    <x-jetax-docs-preview-section title="Posicoes" :code="$codePositions">
        <div class="flex flex-wrap gap-3">
            <x-jetax-button @click="$dispatch('offcanvas-open', 'demo-offcanvas-right')">Direita</x-jetax-button>
            <x-jetax-button @click="$dispatch('offcanvas-open', 'demo-offcanvas-left')">Esquerda</x-jetax-button>
            <x-jetax-button @click="$dispatch('offcanvas-open', 'demo-offcanvas-top')">Topo</x-jetax-button>
            <x-jetax-button @click="$dispatch('offcanvas-open', 'demo-offcanvas-bottom')">Inferior</x-jetax-button>
        </div>

        <x-jetax-offcanvas id="demo-offcanvas-right" position="right">
            <x-slot:header>Direita</x-slot:header>
            <p>Painel a direita.</p>
        </x-jetax-offcanvas>

        <x-jetax-offcanvas id="demo-offcanvas-left" position="left">
            <x-slot:header>Esquerda</x-slot:header>
            <p>Painel a esquerda.</p>
        </x-jetax-offcanvas>

        <x-jetax-offcanvas id="demo-offcanvas-top" position="top">
            <x-slot:header>Topo</x-slot:header>
            <p>Painel no topo.</p>
        </x-jetax-offcanvas>

        <x-jetax-offcanvas id="demo-offcanvas-bottom" position="bottom">
            <x-slot:header>Inferior</x-slot:header>
            <p>Painel inferior.</p>
        </x-jetax-offcanvas>
    </x-jetax-docs-preview-section>

    {{-- Com Header e Footer --}}
    <x-jetax-docs-preview-section title="Com Header e Footer" :code="$codeSlots">
        <x-jetax-button @click="$dispatch('offcanvas-open', 'demo-offcanvas-slots')">
            Abrir com Header e Footer
        </x-jetax-button>

        <x-jetax-offcanvas id="demo-offcanvas-slots">
            <x-slot:header>Titulo via Header</x-slot:header>
            <p>Conteudo do painel.</p>
            <x-slot:footer>
                <x-jetax-button style="soft" @click="$dispatch('offcanvas-close', 'demo-offcanvas-slots')">
                    Cancelar
                </x-jetax-button>
                <x-jetax-button color="primary">Aplicar</x-jetax-button>
            </x-slot:footer>
        </x-jetax-offcanvas>
    </x-jetax-docs-preview-section>

</div>
