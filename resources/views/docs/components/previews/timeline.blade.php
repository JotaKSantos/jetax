@php
$codeVertical = <<<'BLADE'
<x-jetax-timeline>
    <x-jetax-timeline-item title="Pedido realizado" date="10/01/2025" description="Pedido confirmado com sucesso." />
    <x-jetax-timeline-item title="Pagamento aprovado" date="10/01/2025" description="Pagamento via cartao aprovado." color="success" />
    <x-jetax-timeline-item title="Enviado" date="11/01/2025" description="Pacote em transito." color="info" />
    <x-jetax-timeline-item title="Entregue" date="12/01/2025" description="Recebido pelo destinatario." color="success" />
</x-jetax-timeline>
BLADE;

$codeHorizontal = <<<'BLADE'
<x-jetax-timeline :horizontal="true">
    <x-jetax-timeline-item title="Cadastro" date="01/2025" color="success" />
    <x-jetax-timeline-item title="Verificacao" date="02/2025" color="warning" />
    <x-jetax-timeline-item title="Aprovacao" date="03/2025" color="primary" />
</x-jetax-timeline>
BLADE;

$codeIcones = <<<'BLADE'
<x-jetax-timeline>
    <x-jetax-timeline-item title="Conta criada" date="10/01/2025" description="Bem-vindo ao sistema." icon="person_add" color="primary" />
    <x-jetax-timeline-item title="E-mail verificado" date="10/01/2025" description="Verificacao concluida." icon="mark_email_read" color="success" />
    <x-jetax-timeline-item title="Primeiro acesso" date="11/01/2025" description="Login realizado." icon="login" color="info" />
</x-jetax-timeline>
BLADE;

$codeCores = <<<'BLADE'
<x-jetax-timeline>
    <x-jetax-timeline-item title="Primary" date="Etapa 1" color="primary" />
    <x-jetax-timeline-item title="Success" date="Etapa 2" color="success" />
    <x-jetax-timeline-item title="Warning" date="Etapa 3" color="warning" />
    <x-jetax-timeline-item title="Danger" date="Etapa 4" color="danger" />
    <x-jetax-timeline-item title="Info" date="Etapa 5" color="info" />
    <x-jetax-timeline-item title="Secondary" date="Etapa 6" color="secondary" />
</x-jetax-timeline>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Vertical --}}
    <x-jetax-docs-preview-section title="Vertical" :code="$codeVertical">
        <div class="max-w-lg">
            <x-jetax-timeline>
                <x-jetax-timeline-item title="Pedido realizado" date="10/01/2025" description="Pedido confirmado com sucesso." />
                <x-jetax-timeline-item title="Pagamento aprovado" date="10/01/2025" description="Pagamento via cartao aprovado." color="success" />
                <x-jetax-timeline-item title="Enviado" date="11/01/2025" description="Pacote em transito." color="info" />
                <x-jetax-timeline-item title="Entregue" date="12/01/2025" description="Recebido pelo destinatario." color="success" />
            </x-jetax-timeline>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Horizontal --}}
    <x-jetax-docs-preview-section title="Horizontal" :code="$codeHorizontal">
        <x-jetax-timeline :horizontal="true">
            <x-jetax-timeline-item title="Cadastro" date="01/2025" color="success" />
            <x-jetax-timeline-item title="Verificacao" date="02/2025" color="warning" />
            <x-jetax-timeline-item title="Aprovacao" date="03/2025" color="primary" />
        </x-jetax-timeline>
    </x-jetax-docs-preview-section>

    {{-- Com Icones --}}
    <x-jetax-docs-preview-section title="Com Icones" :code="$codeIcones">
        <div class="max-w-lg">
            <x-jetax-timeline>
                <x-jetax-timeline-item title="Conta criada" date="10/01/2025" description="Bem-vindo ao sistema." icon="person_add" color="primary" />
                <x-jetax-timeline-item title="E-mail verificado" date="10/01/2025" description="Verificacao concluida." icon="mark_email_read" color="success" />
                <x-jetax-timeline-item title="Primeiro acesso" date="11/01/2025" description="Login realizado." icon="login" color="info" />
            </x-jetax-timeline>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Cores --}}
    <x-jetax-docs-preview-section title="Cores" :code="$codeCores">
        <div class="max-w-lg">
            <x-jetax-timeline>
                <x-jetax-timeline-item title="Primary" date="Etapa 1" color="primary" />
                <x-jetax-timeline-item title="Success" date="Etapa 2" color="success" />
                <x-jetax-timeline-item title="Warning" date="Etapa 3" color="warning" />
                <x-jetax-timeline-item title="Danger" date="Etapa 4" color="danger" />
                <x-jetax-timeline-item title="Info" date="Etapa 5" color="info" />
                <x-jetax-timeline-item title="Secondary" date="Etapa 6" color="secondary" />
            </x-jetax-timeline>
        </div>
    </x-jetax-docs-preview-section>

</div>
