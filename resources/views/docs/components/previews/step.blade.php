@php
$codeBasico = <<<'BLADE'
<x-jetax-step :current="2">
    <x-jetax-step-item :step="1" label="Dados pessoais" />
    <x-jetax-step-item :step="2" label="Endereço" />
    <x-jetax-step-item :step="3" label="Pagamento" />
    <x-jetax-step-item :step="4" label="Confirmação" />
</x-jetax-step>
BLADE;

$codeVertical = <<<'BLADE'
<x-jetax-step :current="2" :vertical="true">
    <x-jetax-step-item :step="1" label="Dados pessoais" />
    <x-jetax-step-item :step="2" label="Endereço" />
    <x-jetax-step-item :step="3" label="Pagamento" />
    <x-jetax-step-item :step="4" label="Confirmação" />
</x-jetax-step>
BLADE;

$codeClickable = <<<'BLADE'
<x-jetax-step :current="3" :clickable="true">
    <x-jetax-step-item :step="1" label="Dados pessoais" />
    <x-jetax-step-item :step="2" label="Endereço" />
    <x-jetax-step-item :step="3" label="Pagamento" />
    <x-jetax-step-item :step="4" label="Confirmação" />
</x-jetax-step>
BLADE;

$codeDescricao = <<<'BLADE'
<x-jetax-step :current="2">
    <x-jetax-step-item :step="1" label="Conta" description="Crie sua conta" />
    <x-jetax-step-item :step="2" label="Perfil" description="Complete seu perfil" />
    <x-jetax-step-item :step="3" label="Plano" description="Escolha um plano" />
    <x-jetax-step-item :step="4" label="Pronto" description="Comece a usar" />
</x-jetax-step>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <x-jetax-step :current="2">
            <x-jetax-step-item :step="1" label="Dados pessoais" />
            <x-jetax-step-item :step="2" label="Endereço" />
            <x-jetax-step-item :step="3" label="Pagamento" />
            <x-jetax-step-item :step="4" label="Confirmação" />
        </x-jetax-step>
    </x-jetax-docs-preview-section>

    {{-- Vertical --}}
    <x-jetax-docs-preview-section title="Vertical" :code="$codeVertical">
        <x-jetax-step :current="2" :vertical="true">
            <x-jetax-step-item :step="1" label="Dados pessoais" />
            <x-jetax-step-item :step="2" label="Endereço" />
            <x-jetax-step-item :step="3" label="Pagamento" />
            <x-jetax-step-item :step="4" label="Confirmação" />
        </x-jetax-step>
    </x-jetax-docs-preview-section>

    {{-- Clicavel --}}
    <x-jetax-docs-preview-section title="Clicavel" :code="$codeClickable">
        <x-jetax-step :current="3" :clickable="true">
            <x-jetax-step-item :step="1" label="Dados pessoais" />
            <x-jetax-step-item :step="2" label="Endereço" />
            <x-jetax-step-item :step="3" label="Pagamento" />
            <x-jetax-step-item :step="4" label="Confirmação" />
        </x-jetax-step>
    </x-jetax-docs-preview-section>

    {{-- Com descricao --}}
    <x-jetax-docs-preview-section title="Com Descricao" :code="$codeDescricao">
        <x-jetax-step :current="2">
            <x-jetax-step-item :step="1" label="Conta" description="Crie sua conta" />
            <x-jetax-step-item :step="2" label="Perfil" description="Complete seu perfil" />
            <x-jetax-step-item :step="3" label="Plano" description="Escolha um plano" />
            <x-jetax-step-item :step="4" label="Pronto" description="Comece a usar" />
        </x-jetax-step>
    </x-jetax-docs-preview-section>

</div>
