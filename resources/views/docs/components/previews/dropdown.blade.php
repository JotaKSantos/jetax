@php
$codeBasic = <<<'BLADE'
<x-jetax-dropdown>
    <x-slot:trigger>
        <x-jetax-button icon="ellipsis-vertical" style="outline" color="secondary">Acoes</x-jetax-button>
    </x-slot:trigger>

    <x-jetax-dropdown-item icon="pen">Editar</x-jetax-dropdown-item>
    <x-jetax-dropdown-item icon="copy">Duplicar</x-jetax-dropdown-item>
    <x-jetax-dropdown-item icon="download">Exportar</x-jetax-dropdown-item>
</x-jetax-dropdown>
BLADE;

$codeDestructive = <<<'BLADE'
<x-jetax-dropdown>
    <x-slot:trigger>
        <x-jetax-button icon="gear" style="soft">Opcoes</x-jetax-button>
    </x-slot:trigger>

    <x-jetax-dropdown-item icon="pen">Editar</x-jetax-dropdown-item>
    <x-jetax-dropdown-item icon="box-archive">Arquivar</x-jetax-dropdown-item>
    <x-jetax-dropdown-separator />
    <x-jetax-dropdown-item icon="trash" :destructive="true">Excluir</x-jetax-dropdown-item>
</x-jetax-dropdown>
BLADE;

$codeEnd = <<<'BLADE'
<x-jetax-dropdown position="bottom-end">
    <x-slot:trigger>
        <x-jetax-button icon="ellipsis" style="outline" color="secondary">Menu</x-jetax-button>
    </x-slot:trigger>

    <x-jetax-dropdown-item icon="user">Perfil</x-jetax-dropdown-item>
    <x-jetax-dropdown-item icon="gear">Configuracoes</x-jetax-dropdown-item>
    <x-jetax-dropdown-separator />
    <x-jetax-dropdown-item icon="right-from-bracket">Sair</x-jetax-dropdown-item>
</x-jetax-dropdown>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-dropdown>
            <x-slot:trigger>
                <x-jetax-button icon="ellipsis-vertical" style="outline" color="secondary">Acoes</x-jetax-button>
            </x-slot:trigger>

            <x-jetax-dropdown-item icon="pen">Editar</x-jetax-dropdown-item>
            <x-jetax-dropdown-item icon="copy">Duplicar</x-jetax-dropdown-item>
            <x-jetax-dropdown-item icon="download">Exportar</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    </x-jetax-docs-preview-section>

    {{-- Com separador e acao destrutiva --}}
    <x-jetax-docs-preview-section title="Com separador e acao destrutiva" :code="$codeDestructive">
        <x-jetax-dropdown>
            <x-slot:trigger>
                <x-jetax-button icon="gear" style="soft">Opcoes</x-jetax-button>
            </x-slot:trigger>

            <x-jetax-dropdown-item icon="pen">Editar</x-jetax-dropdown-item>
            <x-jetax-dropdown-item icon="box-archive">Arquivar</x-jetax-dropdown-item>
            <x-jetax-dropdown-separator />
            <x-jetax-dropdown-item icon="trash" :destructive="true">Excluir</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    </x-jetax-docs-preview-section>

    {{-- Alinhamento direito --}}
    <x-jetax-docs-preview-section title="Alinhamento direito (bottom-end)" :code="$codeEnd">
        <div class="flex justify-end">
            <x-jetax-dropdown position="bottom-end">
                <x-slot:trigger>
                    <x-jetax-button icon="ellipsis" style="outline" color="secondary">Menu</x-jetax-button>
                </x-slot:trigger>

                <x-jetax-dropdown-item icon="user">Perfil</x-jetax-dropdown-item>
                <x-jetax-dropdown-item icon="gear">Configuracoes</x-jetax-dropdown-item>
                <x-jetax-dropdown-separator />
                <x-jetax-dropdown-item icon="right-from-bracket">Sair</x-jetax-dropdown-item>
            </x-jetax-dropdown>
        </div>
    </x-jetax-docs-preview-section>

</div>
