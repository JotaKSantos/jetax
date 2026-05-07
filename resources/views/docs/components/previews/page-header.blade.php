@php
$codeBasico = <<<'BLADE'
<x-jetax-page-header title="Usuarios" />
BLADE;

$codeSubtitulo = <<<'BLADE'
<x-jetax-page-header
    title="Usuarios"
    subtitle="Gerencie os usuarios do sistema."
/>
BLADE;

$codeBreadcrumbs = <<<'BLADE'
<x-jetax-page-header
    title="Usuarios"
    :breadcrumbs="[
        ['label' => 'Inicio', 'url' => '/'],
        ['label' => 'Admin', 'url' => '/admin'],
        ['label' => 'Usuarios'],
    ]"
/>
BLADE;

$codeActions = <<<'BLADE'
<x-jetax-page-header title="Usuarios">
    <x-slot:actions>
        <x-jetax-button size="sm" style="soft" icon="download">Exportar</x-jetax-button>
        <x-jetax-button size="sm" icon="add">Novo Usuario</x-jetax-button>
    </x-slot:actions>
</x-jetax-page-header>
BLADE;

$codeCompleto = <<<'BLADE'
<x-jetax-page-header
    title="Usuarios"
    subtitle="Gerencie os usuarios do sistema."
    :breadcrumbs="[
        ['label' => 'Inicio', 'url' => '/'],
        ['label' => 'Admin', 'url' => '/admin'],
        ['label' => 'Usuarios'],
    ]"
>
    <x-slot:actions>
        <x-jetax-button size="sm" style="soft" icon="download">Exportar</x-jetax-button>
        <x-jetax-button size="sm" icon="add">Novo Usuario</x-jetax-button>
    </x-slot:actions>
</x-jetax-page-header>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <x-jetax-page-header title="Usuarios" />
    </x-jetax-docs-preview-section>

    {{-- Com Subtitulo --}}
    <x-jetax-docs-preview-section title="Com Subtitulo" :code="$codeSubtitulo">
        <x-jetax-page-header
            title="Usuarios"
            subtitle="Gerencie os usuarios do sistema."
        />
    </x-jetax-docs-preview-section>

    {{-- Com Breadcrumbs --}}
    <x-jetax-docs-preview-section title="Com Breadcrumbs" :code="$codeBreadcrumbs">
        <x-jetax-page-header
            title="Usuarios"
            :breadcrumbs="[
                ['label' => 'Inicio', 'url' => '/'],
                ['label' => 'Admin', 'url' => '/admin'],
                ['label' => 'Usuarios'],
            ]"
        />
    </x-jetax-docs-preview-section>

    {{-- Com Actions --}}
    <x-jetax-docs-preview-section title="Com Actions" :code="$codeActions">
        <div class="w-full">
            <x-jetax-page-header title="Usuarios">
                <x-slot:actions>
                    <x-jetax-button size="sm" style="soft" icon="download">Exportar</x-jetax-button>
                    <x-jetax-button size="sm" icon="add">Novo Usuario</x-jetax-button>
                </x-slot:actions>
            </x-jetax-page-header>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Completo --}}
    <x-jetax-docs-preview-section title="Completo" :code="$codeCompleto">
        <div class="w-full">
            <x-jetax-page-header
                title="Usuarios"
                subtitle="Gerencie os usuarios do sistema."
                :breadcrumbs="[
                    ['label' => 'Inicio', 'url' => '/'],
                    ['label' => 'Admin', 'url' => '/admin'],
                    ['label' => 'Usuarios'],
                ]"
            >
                <x-slot:actions>
                    <x-jetax-button size="sm" style="soft" icon="download">Exportar</x-jetax-button>
                    <x-jetax-button size="sm" icon="add">Novo Usuario</x-jetax-button>
                </x-slot:actions>
            </x-jetax-page-header>
        </div>
    </x-jetax-docs-preview-section>

</div>
