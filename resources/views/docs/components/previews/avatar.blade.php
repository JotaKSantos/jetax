@php
$sizes = ['xs', 'sm', 'md', 'lg', 'xl', 'xxl'];

$codeInitials = <<<'BLADE'
<x-jetax-avatar name="Joao Silva" />
<x-jetax-avatar name="Ana Lima" />
<x-jetax-avatar name="Carlos Souza" />
<x-jetax-avatar name="Maria Oliveira" />
BLADE;

$codeImage = <<<'BLADE'
<x-jetax-avatar src="https://i.pravatar.cc/150?u=1" name="Joao Silva" />
<x-jetax-avatar src="https://i.pravatar.cc/150?u=2" name="Ana Lima" />
<x-jetax-avatar src="https://i.pravatar.cc/150?u=3" name="Carlos Souza" />
BLADE;

$codeSizes = implode("\n", array_map(fn($s) => '<x-jetax-avatar name="Joao Silva" size="' . $s . '" />', $sizes));

$codeSquare = <<<'BLADE'
<x-jetax-avatar name="Joao Silva" :rounded="false" />
<x-jetax-avatar name="Ana Lima" :rounded="false" />
<x-jetax-avatar src="https://i.pravatar.cc/150?u=1" name="Carlos" :rounded="false" />
BLADE;

$codeStatus = <<<'BLADE'
<x-jetax-avatar name="Online" status="online" />
<x-jetax-avatar name="Offline" status="offline" />
<x-jetax-avatar name="Bloqueado" status="blocked" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Iniciais --}}
    <x-jetax-docs-preview-section title="Iniciais" :code="$codeInitials">
        <x-jetax-avatar name="Joao Silva" />
        <x-jetax-avatar name="Ana Lima" />
        <x-jetax-avatar name="Carlos Souza" />
        <x-jetax-avatar name="Maria Oliveira" />
    </x-jetax-docs-preview-section>

    {{-- Com Imagem --}}
    <x-jetax-docs-preview-section title="Com Imagem" :code="$codeImage">
        <x-jetax-avatar src="https://i.pravatar.cc/150?u=1" name="Joao Silva" />
        <x-jetax-avatar src="https://i.pravatar.cc/150?u=2" name="Ana Lima" />
        <x-jetax-avatar src="https://i.pravatar.cc/150?u=3" name="Carlos Souza" />
    </x-jetax-docs-preview-section>

    {{-- Tamanhos --}}
    <x-jetax-docs-preview-section title="Tamanhos" :code="$codeSizes">
        @foreach($sizes as $size)
            <x-jetax-avatar name="Joao Silva" :size="$size" />
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Quadrado --}}
    <x-jetax-docs-preview-section title="Quadrado" :code="$codeSquare">
        <x-jetax-avatar name="Joao Silva" :rounded="false" />
        <x-jetax-avatar name="Ana Lima" :rounded="false" />
        <x-jetax-avatar src="https://i.pravatar.cc/150?u=1" name="Carlos" :rounded="false" />
    </x-jetax-docs-preview-section>

    {{-- Indicador de Status --}}
    <x-jetax-docs-preview-section title="Indicador de Status" :code="$codeStatus">
        <x-jetax-avatar name="Online" status="online" />
        <x-jetax-avatar name="Offline" status="offline" />
        <x-jetax-avatar name="Bloqueado" status="blocked" />
    </x-jetax-docs-preview-section>

</div>
