@php
$codeBasic = <<<'BLADE'
<x-jetax-breadcrumbs :items="[
    ['label' => 'Inicio', 'url' => '/'],
    ['label' => 'Usuarios', 'url' => '/users'],
    ['label' => 'Perfil'],
]" />
BLADE;

$codeLong = <<<'BLADE'
<x-jetax-breadcrumbs :items="[
    ['label' => 'Inicio', 'url' => '/'],
    ['label' => 'Configuracoes', 'url' => '/settings'],
    ['label' => 'Empresa', 'url' => '/settings/company'],
    ['label' => 'Departamentos', 'url' => '/settings/company/departments'],
    ['label' => 'Engenharia'],
]" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <x-jetax-breadcrumbs :items="[
            ['label' => 'Inicio', 'url' => '/'],
            ['label' => 'Usuarios', 'url' => '/users'],
            ['label' => 'Perfil'],
        ]" />
    </x-jetax-docs-preview-section>

    {{-- Com muitos itens --}}
    <x-jetax-docs-preview-section title="Com muitos itens" :code="$codeLong">
        <x-jetax-breadcrumbs :items="[
            ['label' => 'Inicio', 'url' => '/'],
            ['label' => 'Configuracoes', 'url' => '/settings'],
            ['label' => 'Empresa', 'url' => '/settings/company'],
            ['label' => 'Departamentos', 'url' => '/settings/company/departments'],
            ['label' => 'Engenharia'],
        ]" />
    </x-jetax-docs-preview-section>

</div>
