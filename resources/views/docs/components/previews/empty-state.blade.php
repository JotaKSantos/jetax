@php
$codeBasic = <<<'BLADE'
<x-jetax-empty-state
    title="Nenhum resultado"
    description="Tente ajustar os filtros de busca."
    icon="magnifying-glass"
/>
BLADE;

$codeAction = <<<'BLADE'
<x-jetax-empty-state
    title="Sem registros"
    description="Comece adicionando o primeiro item."
    icon="inbox"
>
    <x-jetax-button icon="plus" color="primary">Criar novo</x-jetax-button>
</x-jetax-empty-state>
BLADE;

$codeTypes = <<<'BLADE'
<x-jetax-empty-state
    title="Lista vazia"
    description="Nenhum item cadastrado ainda."
    icon="folder-open"
    type="empty"
/>

<x-jetax-empty-state
    title="Nenhum resultado encontrado"
    description="Tente buscar com outros termos."
    icon="magnifying-glass"
    type="no-results"
/>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-empty-state
            title="Nenhum resultado"
            description="Tente ajustar os filtros de busca."
            icon="magnifying-glass"
        />
    </x-jetax-docs-preview-section>

    {{-- Com Acao --}}
    <x-jetax-docs-preview-section title="Com Acao" :code="$codeAction">
        <x-jetax-empty-state
            title="Sem registros"
            description="Comece adicionando o primeiro item."
            icon="inbox"
        >
            <x-jetax-button icon="plus" color="primary">Criar novo</x-jetax-button>
        </x-jetax-empty-state>
    </x-jetax-docs-preview-section>

    {{-- Tipos --}}
    <x-jetax-docs-preview-section title="Tipos" :code="$codeTypes">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
            <x-jetax-empty-state
                title="Lista vazia"
                description="Nenhum item cadastrado ainda."
                icon="folder-open"
                type="empty"
            />
            <x-jetax-empty-state
                title="Nenhum resultado encontrado"
                description="Tente buscar com outros termos."
                icon="magnifying-glass"
                type="no-results"
            />
        </div>
    </x-jetax-docs-preview-section>

</div>
