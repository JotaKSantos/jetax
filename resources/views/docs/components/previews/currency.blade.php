@php
$codeBrl = <<<'BLADE'
<x-jetax-currency name="preco" currency="R$" locale="pt-BR" />
BLADE;

$codeOther = <<<'BLADE'
<x-jetax-currency name="price_usd" currency="$" locale="en-US" />
<x-jetax-currency name="price_eur" currency="€" locale="es-ES" />
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-currency name="preco_off" currency="R$" locale="pt-BR" disabled />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico (BRL) --}}
    <x-jetax-docs-preview-section title="Real Brasileiro" :code="$codeBrl">
        <div class="w-full max-w-sm">
            <x-jetax-currency name="preco" currency="R$" locale="pt-BR" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Outras Moedas --}}
    <x-jetax-docs-preview-section title="Outras Moedas" :code="$codeOther">
        <div class="w-full max-w-sm space-y-4">
            <x-jetax-currency name="price_usd" currency="$" locale="en-US" />
            <x-jetax-currency name="price_eur" currency="€" locale="es-ES" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <div class="w-full max-w-sm">
            <x-jetax-currency name="preco_off" currency="R$" locale="pt-BR" disabled />
        </div>
    </x-jetax-docs-preview-section>

</div>
