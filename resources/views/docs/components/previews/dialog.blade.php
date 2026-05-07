@php
$codeBasic = <<<'BLADE'
<x-jetax-button color="danger" &#64;click="$dispatch('dialog-open', { id: 'meu-dialog' })">
    Excluir Registro
</x-jetax-button>

<x-jetax-dialog
    id="meu-dialog"
    title="Excluir registro"
    message="Esta acao nao pode ser desfeita. Deseja continuar?"
    confirm-label="Excluir"
    cancel-label="Cancelar"
    variant="danger"
/>
BLADE;

$codeVariants = <<<'BLADE'
<x-jetax-dialog
    id="dialog-danger"
    title="Excluir registro"
    message="Esta acao nao pode ser desfeita."
    confirm-label="Excluir"
    variant="danger"
/>

<x-jetax-dialog
    id="dialog-warning"
    title="Atencao"
    message="Voce esta prestes a alterar dados sensiveis."
    confirm-label="Continuar"
    variant="warning"
/>

<x-jetax-dialog
    id="dialog-primary"
    title="Confirmar acao"
    message="Deseja prosseguir com esta operacao?"
    confirm-label="Prosseguir"
    variant="primary"
/>

<x-jetax-dialog
    id="dialog-success"
    title="Publicar"
    message="O conteudo sera publicado imediatamente."
    confirm-label="Publicar"
    variant="success"
/>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-button color="danger" @click="$dispatch('dialog-open', { id: 'demo-dialog-basic' })">
            Excluir Registro
        </x-jetax-button>

        <x-jetax-dialog
            id="demo-dialog-basic"
            title="Excluir registro"
            message="Esta acao nao pode ser desfeita. Deseja continuar?"
            confirm-label="Excluir"
            cancel-label="Cancelar"
            variant="danger"
        />
    </x-jetax-docs-preview-section>

    {{-- Variantes --}}
    <x-jetax-docs-preview-section title="Variantes" :code="$codeVariants">
        <div class="flex flex-wrap gap-3">
            <x-jetax-button color="danger" @click="$dispatch('dialog-open', { id: 'demo-dialog-danger' })">
                Danger
            </x-jetax-button>
            <x-jetax-button color="warning" @click="$dispatch('dialog-open', { id: 'demo-dialog-warning' })">
                Warning
            </x-jetax-button>
            <x-jetax-button color="primary" @click="$dispatch('dialog-open', { id: 'demo-dialog-primary' })">
                Primary
            </x-jetax-button>
            <x-jetax-button color="success" @click="$dispatch('dialog-open', { id: 'demo-dialog-success' })">
                Success
            </x-jetax-button>
        </div>

        <x-jetax-dialog
            id="demo-dialog-danger"
            title="Excluir registro"
            message="Esta acao nao pode ser desfeita."
            confirm-label="Excluir"
            variant="danger"
        />

        <x-jetax-dialog
            id="demo-dialog-warning"
            title="Atencao"
            message="Voce esta prestes a alterar dados sensiveis."
            confirm-label="Continuar"
            variant="warning"
        />

        <x-jetax-dialog
            id="demo-dialog-primary"
            title="Confirmar acao"
            message="Deseja prosseguir com esta operacao?"
            confirm-label="Prosseguir"
            variant="primary"
        />

        <x-jetax-dialog
            id="demo-dialog-success"
            title="Publicar"
            message="O conteudo sera publicado imediatamente."
            confirm-label="Publicar"
            variant="success"
        />
    </x-jetax-docs-preview-section>

</div>
