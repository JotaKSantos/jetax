@php
$colors = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark', 'light'];

$codeSolid = implode("\n", array_map(fn($c) => '<x-jetax-button color="' . $c . '">' . ucfirst($c) . '</x-jetax-button>', $colors));

$codeRounded = implode("\n", array_map(fn($c) => '<x-jetax-button style="rounded" color="' . $c . '">' . ucfirst($c) . '</x-jetax-button>', $colors));

$codeOutline = implode("\n", array_map(fn($c) => '<x-jetax-button style="outline" color="' . $c . '">' . ucfirst($c) . '</x-jetax-button>', $colors));

$codeOutlineRounded = implode("\n", array_map(fn($c) => '<x-jetax-button style="outline-rounded" color="' . $c . '">' . ucfirst($c) . '</x-jetax-button>', $colors));

$codeSoft = implode("\n", array_map(fn($c) => '<x-jetax-button style="soft" color="' . $c . '">' . ucfirst($c) . '</x-jetax-button>', $colors));

$codeSoftRounded = implode("\n", array_map(fn($c) => '<x-jetax-button style="soft-rounded" color="' . $c . '">' . ucfirst($c) . '</x-jetax-button>', $colors));

$codeSizes = <<<'BLADE'
<x-jetax-button size="sm">Pequeno</x-jetax-button>
<x-jetax-button size="md">Medio</x-jetax-button>
<x-jetax-button size="lg">Grande</x-jetax-button>
BLADE;

$codeIcons = <<<'BLADE'
<x-jetax-button icon="save">Salvar</x-jetax-button>
<x-jetax-button icon="delete" color="danger">Excluir</x-jetax-button>
<x-jetax-button icon="send" icon-position="right" color="success">Enviar</x-jetax-button>
<x-jetax-button icon="person_add" style="outline" color="info">Adicionar</x-jetax-button>
<x-jetax-button icon="edit" style="soft" color="warning">Editar</x-jetax-button>
BLADE;

$codeLoading = <<<'BLADE'
<x-jetax-button :loading="true">Aguarde...</x-jetax-button>
<x-jetax-button :loading="true" color="success">Processando</x-jetax-button>
<x-jetax-button :loading="true" color="danger" style="outline">Excluindo</x-jetax-button>
BLADE;

$codeBlock = <<<'BLADE'
<x-jetax-button :block="true" color="primary">Botao Full Width</x-jetax-button>
<x-jetax-button :block="true" color="success" style="outline">Confirmar</x-jetax-button>
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-button disabled>Desabilitado</x-jetax-button>
<x-jetax-button disabled style="outline" color="primary">Outline Desabilitado</x-jetax-button>
<x-jetax-button disabled style="soft" color="success">Soft Desabilitado</x-jetax-button>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Botoes Padrao --}}
    <x-jetax-docs-preview-section title="Botoes Padrao" :code="$codeSolid">
        @foreach($colors as $color)
            <x-jetax-button :color="$color">{{ ucfirst($color) }}</x-jetax-button>
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Botoes Arredondados --}}
    <x-jetax-docs-preview-section title="Botoes Arredondados" :code="$codeRounded">
        @foreach($colors as $color)
            <x-jetax-button style="rounded" :color="$color">{{ ucfirst($color) }}</x-jetax-button>
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Botoes Outline --}}
    <x-jetax-docs-preview-section title="Botoes Outline" :code="$codeOutline">
        @foreach($colors as $color)
            <x-jetax-button style="outline" :color="$color">{{ ucfirst($color) }}</x-jetax-button>
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Botoes Outline Arredondados --}}
    <x-jetax-docs-preview-section title="Botoes Outline Arredondados" :code="$codeOutlineRounded">
        @foreach($colors as $color)
            <x-jetax-button style="outline-rounded" :color="$color">{{ ucfirst($color) }}</x-jetax-button>
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Botoes Soft --}}
    <x-jetax-docs-preview-section title="Botoes Soft" :code="$codeSoft">
        @foreach($colors as $color)
            <x-jetax-button style="soft" :color="$color">{{ ucfirst($color) }}</x-jetax-button>
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Botoes Soft Arredondados --}}
    <x-jetax-docs-preview-section title="Botoes Soft Arredondados" :code="$codeSoftRounded">
        @foreach($colors as $color)
            <x-jetax-button style="soft-rounded" :color="$color">{{ ucfirst($color) }}</x-jetax-button>
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Tamanhos --}}
    <x-jetax-docs-preview-section title="Tamanhos" :code="$codeSizes">
        <x-jetax-button size="sm">Pequeno</x-jetax-button>
        <x-jetax-button size="md">Medio</x-jetax-button>
        <x-jetax-button size="lg">Grande</x-jetax-button>
    </x-jetax-docs-preview-section>

    {{-- Com Icone --}}
    <x-jetax-docs-preview-section title="Com Icone" :code="$codeIcons">
        <x-jetax-button icon="save">Salvar</x-jetax-button>
        <x-jetax-button icon="delete" color="danger">Excluir</x-jetax-button>
        <x-jetax-button icon="send" icon-position="right" color="success">Enviar</x-jetax-button>
        <x-jetax-button icon="person_add" style="outline" color="info">Adicionar</x-jetax-button>
        <x-jetax-button icon="edit" style="soft" color="warning">Editar</x-jetax-button>
    </x-jetax-docs-preview-section>

    {{-- Estado de Carregamento --}}
    <x-jetax-docs-preview-section title="Estado de Carregamento" :code="$codeLoading">
        <x-jetax-button :loading="true">Aguarde...</x-jetax-button>
        <x-jetax-button :loading="true" color="success">Processando</x-jetax-button>
        <x-jetax-button :loading="true" color="danger" style="outline">Excluindo</x-jetax-button>
    </x-jetax-docs-preview-section>

    {{-- Largura Total --}}
    <x-jetax-docs-preview-section title="Largura Total (Block)" :code="$codeBlock">
        <div class="w-full space-y-2">
            <x-jetax-button :block="true" color="primary">Botao Full Width</x-jetax-button>
            <x-jetax-button :block="true" color="success" style="outline">Confirmar</x-jetax-button>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <x-jetax-button disabled>Desabilitado</x-jetax-button>
        <x-jetax-button disabled style="outline" color="primary">Outline Desabilitado</x-jetax-button>
        <x-jetax-button disabled style="soft" color="success">Soft Desabilitado</x-jetax-button>
    </x-jetax-docs-preview-section>

</div>
