@php
$codeBasic = <<<'BLADE'
<x-jetax-pin :length="6" />
BLADE;

$codeCustomLength = <<<'BLADE'
<x-jetax-pin :length="4" />
BLADE;

$codeAlphanumeric = <<<'BLADE'
<x-jetax-pin :length="6" type="alphanumeric" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico (6 digitos)" :code="$codeBasic">
        <x-jetax-pin :length="6" />
    </x-jetax-docs-preview-section>

    {{-- Comprimento Customizado --}}
    <x-jetax-docs-preview-section title="4 Digitos" :code="$codeCustomLength">
        <x-jetax-pin :length="4" />
    </x-jetax-docs-preview-section>

    {{-- Alfanumerico --}}
    <x-jetax-docs-preview-section title="Alfanumerico" :code="$codeAlphanumeric">
        <x-jetax-pin :length="6" type="alphanumeric" />
    </x-jetax-docs-preview-section>

</div>
