@php
$codeBasic = <<<'BLADE'
<x-jetax-chip label="Situação: Quitado" />
<x-jetax-chip>Espécie: Canina</x-jetax-chip>
BLADE;

$codeRemovable = <<<'BLADE'
<x-jetax-chip
    label="Situação: Quitado"
    removable
    wire:click="removeFilter('situacao')"
    remove:data-filter="situacao"
/>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="flex flex-wrap items-center gap-2">
            <x-jetax-chip label="Situação: Quitado" />
            <x-jetax-chip>Espécie: Canina</x-jetax-chip>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Removivel --}}
    <x-jetax-docs-preview-section title="Removivel" :code="$codeRemovable">
        <div class="flex flex-wrap items-center gap-2">
            <x-jetax-chip label="Situação: Quitado" removable x-on:click="$el.closest('span').remove()" />
            <x-jetax-chip label="Período: Hoje" removable x-on:click="$el.closest('span').remove()" />
        </div>
    </x-jetax-docs-preview-section>

</div>
