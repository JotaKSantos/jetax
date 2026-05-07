@php
$codeBasic = <<<'BLADE'
<x-jetax-button &#64;click="$dispatch('modal-open', 'meu-modal')">
    Abrir Modal
</x-jetax-button>

<x-jetax-modal id="meu-modal">
    <x-slot:header>Confirmacao</x-slot:header>
    <p>Deseja realmente excluir este item?</p>
</x-jetax-modal>
BLADE;

$codeSizes = <<<'BLADE'
<x-jetax-modal id="modal-sm" size="sm">
    <x-slot:header>Small</x-slot:header>
    <p>Modal pequeno.</p>
</x-jetax-modal>

<x-jetax-modal id="modal-md" size="md">
    <x-slot:header>Medium</x-slot:header>
    <p>Modal medio (padrao).</p>
</x-jetax-modal>

<x-jetax-modal id="modal-lg" size="lg">
    <x-slot:header>Large</x-slot:header>
    <p>Modal grande.</p>
</x-jetax-modal>

<x-jetax-modal id="modal-fullscreen" size="fullscreen">
    <x-slot:header>Fullscreen</x-slot:header>
    <p>Modal tela cheia.</p>
</x-jetax-modal>
BLADE;

$codeHighRisk = <<<'BLADE'
<x-jetax-modal id="modal-risk" :high-risk="true">
    <x-slot:header>Acao Perigosa</x-slot:header>
    <p>Esta acao nao pode ser desfeita.</p>
</x-jetax-modal>
BLADE;

$codeSlots = <<<'BLADE'
<x-jetax-modal id="modal-slots">
    <x-slot:header>Titulo via Header Slot</x-slot:header>
    <p>Conteudo do corpo do modal.</p>
    <x-slot:footer>
        <x-jetax-button style="soft" &#64;click="$dispatch('modal-close', 'modal-slots')">
            Cancelar
        </x-jetax-button>
        <x-jetax-button color="primary">Confirmar</x-jetax-button>
    </x-slot:footer>
</x-jetax-modal>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-button @click="$dispatch('modal-open', 'demo-modal-basic')">
            Abrir Modal
        </x-jetax-button>

        <x-jetax-modal id="demo-modal-basic">
            <x-slot:header>Confirmacao</x-slot:header>
            <p>Deseja realmente excluir este item?</p>
        </x-jetax-modal>
    </x-jetax-docs-preview-section>

    {{-- Tamanhos --}}
    <x-jetax-docs-preview-section title="Tamanhos" :code="$codeSizes">
        <div class="flex flex-wrap gap-3">
            <x-jetax-button @click="$dispatch('modal-open', 'demo-modal-sm')">Small</x-jetax-button>
            <x-jetax-button @click="$dispatch('modal-open', 'demo-modal-md')">Medium</x-jetax-button>
            <x-jetax-button @click="$dispatch('modal-open', 'demo-modal-lg')">Large</x-jetax-button>
            <x-jetax-button @click="$dispatch('modal-open', 'demo-modal-fullscreen')">Fullscreen</x-jetax-button>
        </div>

        <x-jetax-modal id="demo-modal-sm" size="sm">
            <x-slot:header>Small</x-slot:header>
            <p>Modal pequeno.</p>
        </x-jetax-modal>

        <x-jetax-modal id="demo-modal-md" size="md">
            <x-slot:header>Medium</x-slot:header>
            <p>Modal medio (padrao).</p>
        </x-jetax-modal>

        <x-jetax-modal id="demo-modal-lg" size="lg">
            <x-slot:header>Large</x-slot:header>
            <p>Modal grande.</p>
        </x-jetax-modal>

        <x-jetax-modal id="demo-modal-fullscreen" size="fullscreen">
            <x-slot:header>Fullscreen</x-slot:header>
            <p>Modal tela cheia.</p>
        </x-jetax-modal>
    </x-jetax-docs-preview-section>

    {{-- High Risk --}}
    <x-jetax-docs-preview-section title="High Risk" :code="$codeHighRisk">
        <x-jetax-button color="danger" @click="$dispatch('modal-open', 'demo-modal-risk')">
            Abrir Modal High Risk
        </x-jetax-button>

        <x-jetax-modal id="demo-modal-risk" :high-risk="true">
            <x-slot:header>Acao Perigosa</x-slot:header>
            <p>Esta acao nao pode ser desfeita.</p>
        </x-jetax-modal>
    </x-jetax-docs-preview-section>

    {{-- Com Header e Footer --}}
    <x-jetax-docs-preview-section title="Com Header e Footer" :code="$codeSlots">
        <x-jetax-button @click="$dispatch('modal-open', 'demo-modal-slots')">
            Abrir com Header e Footer
        </x-jetax-button>

        <x-jetax-modal id="demo-modal-slots">
            <x-slot:header>Titulo via Header Slot</x-slot:header>
            <p>Conteudo do corpo do modal.</p>
            <x-slot:footer>
                <x-jetax-button style="soft" @click="$dispatch('modal-close', 'demo-modal-slots')">
                    Cancelar
                </x-jetax-button>
                <x-jetax-button color="primary">Confirmar</x-jetax-button>
            </x-slot:footer>
        </x-jetax-modal>
    </x-jetax-docs-preview-section>

</div>
