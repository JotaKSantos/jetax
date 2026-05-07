@php
$codeBasico = <<<'BLADE'
<x-jetax-accordion>
    <x-jetax-accordion-item title="O que é o Jetax?">
        <p>Um design system completo para Laravel.</p>
    </x-jetax-accordion-item>
    <x-jetax-accordion-item title="Como instalar?">
        <p>Execute composer require jksantos/jetax.</p>
    </x-jetax-accordion-item>
    <x-jetax-accordion-item title="Posso customizar?">
        <p>Sim, todos os componentes são customizáveis.</p>
    </x-jetax-accordion-item>
</x-jetax-accordion>
BLADE;

$codeMultiple = <<<'BLADE'
<x-jetax-accordion mode="multiple">
    <x-jetax-accordion-item title="Primeiro item">
        <p>Este item pode ficar aberto junto com outros.</p>
    </x-jetax-accordion-item>
    <x-jetax-accordion-item title="Segundo item">
        <p>Múltiplos itens podem estar abertos ao mesmo tempo.</p>
    </x-jetax-accordion-item>
    <x-jetax-accordion-item title="Terceiro item">
        <p>Clique em vários para testar o modo múltiplo.</p>
    </x-jetax-accordion-item>
</x-jetax-accordion>
BLADE;

$codeOpen = <<<'BLADE'
<x-jetax-accordion>
    <x-jetax-accordion-item title="Item fechado">
        <p>Este item começa fechado.</p>
    </x-jetax-accordion-item>
    <x-jetax-accordion-item title="Item aberto" :open="true">
        <p>Este item começa aberto por padrão.</p>
    </x-jetax-accordion-item>
</x-jetax-accordion>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <x-jetax-accordion>
            <x-jetax-accordion-item title="O que é o Jetax?">
                <p>Um design system completo para Laravel.</p>
            </x-jetax-accordion-item>
            <x-jetax-accordion-item title="Como instalar?">
                <p>Execute composer require jksantos/jetax.</p>
            </x-jetax-accordion-item>
            <x-jetax-accordion-item title="Posso customizar?">
                <p>Sim, todos os componentes são customizáveis.</p>
            </x-jetax-accordion-item>
        </x-jetax-accordion>
    </x-jetax-docs-preview-section>

    {{-- Multiplo --}}
    <x-jetax-docs-preview-section title="Multiplo" :code="$codeMultiple">
        <x-jetax-accordion mode="multiple">
            <x-jetax-accordion-item title="Primeiro item">
                <p>Este item pode ficar aberto junto com outros.</p>
            </x-jetax-accordion-item>
            <x-jetax-accordion-item title="Segundo item">
                <p>Múltiplos itens podem estar abertos ao mesmo tempo.</p>
            </x-jetax-accordion-item>
            <x-jetax-accordion-item title="Terceiro item">
                <p>Clique em vários para testar o modo múltiplo.</p>
            </x-jetax-accordion-item>
        </x-jetax-accordion>
    </x-jetax-docs-preview-section>

    {{-- Item aberto por padrao --}}
    <x-jetax-docs-preview-section title="Item aberto por padrao" :code="$codeOpen">
        <x-jetax-accordion>
            <x-jetax-accordion-item title="Item fechado">
                <p>Este item começa fechado.</p>
            </x-jetax-accordion-item>
            <x-jetax-accordion-item title="Item aberto" :open="true">
                <p>Este item começa aberto por padrão.</p>
            </x-jetax-accordion-item>
        </x-jetax-accordion>
    </x-jetax-docs-preview-section>

</div>
