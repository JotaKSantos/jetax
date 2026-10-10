@php
$codeBasico = <<<'BLADE'
<x-jetax-list-group>
    <x-jetax-list-group-item title="Perfil" icon="user" />
    <x-jetax-list-group-item title="Configuracoes" icon="gear" />
    <x-jetax-list-group-item title="Notificacoes" icon="bell" />
</x-jetax-list-group>
BLADE;

$codeSubtitulo = <<<'BLADE'
<x-jetax-list-group>
    <x-jetax-list-group-item title="Ana Lima" subtitle="ana@exemplo.com" icon="user" />
    <x-jetax-list-group-item title="Joao Silva" subtitle="joao@exemplo.com" icon="user" />
    <x-jetax-list-group-item title="Maria Santos" subtitle="maria@exemplo.com" icon="user" />
</x-jetax-list-group>
BLADE;

$codeAtivo = <<<'BLADE'
<x-jetax-list-group>
    <x-jetax-list-group-item title="Dashboard" icon="table-cells-large" />
    <x-jetax-list-group-item title="Usuarios" icon="users" :active="true" />
    <x-jetax-list-group-item title="Relatorios" icon="chart-column" />
</x-jetax-list-group>
BLADE;

$codeLink = <<<'BLADE'
<x-jetax-list-group>
    <x-jetax-list-group-item title="Documentacao" icon="file-lines" href="#" />
    <x-jetax-list-group-item title="Repositorio" icon="code" href="#" />
    <x-jetax-list-group-item title="Suporte" icon="circle-question" href="#" />
</x-jetax-list-group>
BLADE;

$codeActions = <<<'BLADE'
<x-jetax-list-group>
    <x-jetax-list-group-item title="backup_2025.zip" icon="file-zipper">
        <x-slot:actions>
            <x-jetax-button size="sm" style="soft" icon="download">Baixar</x-jetax-button>
        </x-slot:actions>
    </x-jetax-list-group-item>
    <x-jetax-list-group-item title="relatorio.pdf" icon="file-pdf">
        <x-slot:actions>
            <x-jetax-button size="sm" style="soft" icon="download">Baixar</x-jetax-button>
        </x-slot:actions>
    </x-jetax-list-group-item>
</x-jetax-list-group>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <div class="max-w-md">
            <x-jetax-list-group>
                <x-jetax-list-group-item title="Perfil" icon="user" />
                <x-jetax-list-group-item title="Configuracoes" icon="gear" />
                <x-jetax-list-group-item title="Notificacoes" icon="bell" />
            </x-jetax-list-group>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Subtitulo --}}
    <x-jetax-docs-preview-section title="Com Subtitulo" :code="$codeSubtitulo">
        <div class="max-w-md">
            <x-jetax-list-group>
                <x-jetax-list-group-item title="Ana Lima" subtitle="ana@exemplo.com" icon="user" />
                <x-jetax-list-group-item title="Joao Silva" subtitle="joao@exemplo.com" icon="user" />
                <x-jetax-list-group-item title="Maria Santos" subtitle="maria@exemplo.com" icon="user" />
            </x-jetax-list-group>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Item Ativo --}}
    <x-jetax-docs-preview-section title="Item Ativo" :code="$codeAtivo">
        <div class="max-w-md">
            <x-jetax-list-group>
                <x-jetax-list-group-item title="Dashboard" icon="table-cells-large" />
                <x-jetax-list-group-item title="Usuarios" icon="users" :active="true" />
                <x-jetax-list-group-item title="Relatorios" icon="chart-column" />
            </x-jetax-list-group>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Como Link --}}
    <x-jetax-docs-preview-section title="Como Link" :code="$codeLink">
        <div class="max-w-md">
            <x-jetax-list-group>
                <x-jetax-list-group-item title="Documentacao" icon="file-lines" href="#" />
                <x-jetax-list-group-item title="Repositorio" icon="code" href="#" />
                <x-jetax-list-group-item title="Suporte" icon="circle-question" href="#" />
            </x-jetax-list-group>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Actions --}}
    <x-jetax-docs-preview-section title="Com Actions" :code="$codeActions">
        <div class="max-w-md">
            <x-jetax-list-group>
                <x-jetax-list-group-item title="backup_2025.zip" icon="file-zipper">
                    <x-slot:actions>
                        <x-jetax-button size="sm" style="soft" icon="download">Baixar</x-jetax-button>
                    </x-slot:actions>
                </x-jetax-list-group-item>
                <x-jetax-list-group-item title="relatorio.pdf" icon="file-pdf">
                    <x-slot:actions>
                        <x-jetax-button size="sm" style="soft" icon="download">Baixar</x-jetax-button>
                    </x-slot:actions>
                </x-jetax-list-group-item>
            </x-jetax-list-group>
        </div>
    </x-jetax-docs-preview-section>

</div>
