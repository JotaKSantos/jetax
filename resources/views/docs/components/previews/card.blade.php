@php
$codeBasico = <<<'BLADE'
<x-jetax-card>
    <x-slot:header>Titulo do Card</x-slot:header>
    <p>Conteudo do card com texto de exemplo.</p>
</x-jetax-card>
BLADE;

$codeHeaderFooter = <<<'BLADE'
<x-jetax-card>
    <x-slot:header>Card com Footer</x-slot:header>
    <p>Conteudo principal do card.</p>
    <x-slot:footer>
        <div class="flex gap-2">
            <x-jetax-button size="sm" style="soft">Cancelar</x-jetax-button>
            <x-jetax-button size="sm">Salvar</x-jetax-button>
        </div>
    </x-slot:footer>
</x-jetax-card>
BLADE;

$codeFeatured = <<<'BLADE'
<x-jetax-card :featured="true">
    <x-slot:header>Card Destacado</x-slot:header>
    <p>Card com borda superior colorida para destaque.</p>
</x-jetax-card>
BLADE;

$codeBordered = <<<'BLADE'
<x-jetax-card :bordered="true">
    <x-slot:header>Card com Borda</x-slot:header>
    <p>Variante com borda sutil e sombra reduzida.</p>
</x-jetax-card>
BLADE;

$codeActions = <<<'BLADE'
<x-jetax-card>
    <x-slot:header>Usuarios</x-slot:header>
    <x-slot:actions>
        <x-jetax-button size="sm" icon="add">Novo</x-jetax-button>
    </x-slot:actions>
    <p>Lista de usuarios aqui.</p>
</x-jetax-card>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <x-jetax-card>
            <x-slot:header>Titulo do Card</x-slot:header>
            <p>Conteudo do card com texto de exemplo.</p>
        </x-jetax-card>
    </x-jetax-docs-preview-section>

    {{-- Com Header e Footer --}}
    <x-jetax-docs-preview-section title="Com Header e Footer" :code="$codeHeaderFooter">
        <x-jetax-card>
            <x-slot:header>Card com Footer</x-slot:header>
            <p>Conteudo principal do card.</p>
            <x-slot:footer>
                <div class="flex gap-2">
                    <x-jetax-button size="sm" style="soft">Cancelar</x-jetax-button>
                    <x-jetax-button size="sm">Salvar</x-jetax-button>
                </div>
            </x-slot:footer>
        </x-jetax-card>
    </x-jetax-docs-preview-section>

    {{-- Featured --}}
    <x-jetax-docs-preview-section title="Featured" :code="$codeFeatured">
        <x-jetax-card :featured="true">
            <x-slot:header>Card Destacado</x-slot:header>
            <p>Card com borda superior colorida para destaque.</p>
        </x-jetax-card>
    </x-jetax-docs-preview-section>

    {{-- Bordered --}}
    <x-jetax-docs-preview-section title="Bordered" :code="$codeBordered">
        <x-jetax-card :bordered="true">
            <x-slot:header>Card com Borda</x-slot:header>
            <p>Variante com borda sutil e sombra reduzida.</p>
        </x-jetax-card>
    </x-jetax-docs-preview-section>

    {{-- Com Actions --}}
    <x-jetax-docs-preview-section title="Com Actions" :code="$codeActions">
        <x-jetax-card>
            <x-slot:header>Usuarios</x-slot:header>
            <x-slot:actions>
                <x-jetax-button size="sm" icon="add">Novo</x-jetax-button>
            </x-slot:actions>
            <p>Lista de usuarios aqui.</p>
        </x-jetax-card>
    </x-jetax-docs-preview-section>

</div>
