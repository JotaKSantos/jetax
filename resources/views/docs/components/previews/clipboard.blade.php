@php
$codeBasico = <<<'BLADE'
<x-jetax-clipboard text="Texto copiado!" />
BLADE;

$codeMensagem = <<<'BLADE'
<x-jetax-clipboard text="abc123" success-message="Copiado com sucesso!" />
BLADE;

$codeTrigger = <<<'BLADE'
<x-jetax-clipboard text="Conteúdo personalizado">
    <x-jetax-button style="soft" size="sm">
        <x-jetax-icon name="content_copy" size="sm" /> Copiar
    </x-jetax-button>
</x-jetax-clipboard>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <x-jetax-clipboard text="Texto copiado!" />
    </x-jetax-docs-preview-section>

    {{-- Mensagem personalizada --}}
    <x-jetax-docs-preview-section title="Mensagem Personalizada" :code="$codeMensagem">
        <x-jetax-clipboard text="abc123" success-message="Copiado com sucesso!" />
    </x-jetax-docs-preview-section>

    {{-- Trigger customizado --}}
    <x-jetax-docs-preview-section title="Trigger Customizado" :code="$codeTrigger">
        <x-jetax-clipboard text="Conteúdo personalizado">
            <x-jetax-button style="soft" size="sm">
                <x-jetax-icon name="content_copy" size="sm" /> Copiar
            </x-jetax-button>
        </x-jetax-clipboard>
    </x-jetax-docs-preview-section>

</div>
