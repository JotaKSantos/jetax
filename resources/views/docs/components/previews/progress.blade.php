@php
$colors = ['primary', 'success', 'warning', 'danger'];

$codeBasic = <<<'BLADE'
<x-jetax-progress :value="25" />
<x-jetax-progress :value="50" />
<x-jetax-progress :value="75" />
<x-jetax-progress :value="100" />
BLADE;

$codeColors = implode("\n", array_map(fn($c) => '<x-jetax-progress :value="65" color="' . $c . '" />', $colors));

$codeSizes = <<<'BLADE'
<x-jetax-progress :value="65" size="sm" />
<x-jetax-progress :value="65" size="md" />
<x-jetax-progress :value="65" size="lg" />
BLADE;

$codeLabel = <<<'BLADE'
<x-jetax-progress :value="42" label="Upload" />
<x-jetax-progress :value="80" label="Download" color="success" />
BLADE;

$codeAnimated = <<<'BLADE'
<x-jetax-progress :value="65" :animated="true" />
<x-jetax-progress :value="45" :animated="true" color="success" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full space-y-3">
            <x-jetax-progress :value="25" />
            <x-jetax-progress :value="50" />
            <x-jetax-progress :value="75" />
            <x-jetax-progress :value="100" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Cores --}}
    <x-jetax-docs-preview-section title="Cores" :code="$codeColors">
        <div class="w-full space-y-3">
            @foreach($colors as $color)
                <x-jetax-progress :value="65" :color="$color" />
            @endforeach
        </div>
    </x-jetax-docs-preview-section>

    {{-- Tamanhos --}}
    <x-jetax-docs-preview-section title="Tamanhos" :code="$codeSizes">
        <div class="w-full space-y-3">
            <x-jetax-progress :value="65" size="sm" />
            <x-jetax-progress :value="65" size="md" />
            <x-jetax-progress :value="65" size="lg" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Rotulo --}}
    <x-jetax-docs-preview-section title="Com Rotulo" :code="$codeLabel">
        <div class="w-full space-y-3">
            <x-jetax-progress :value="42" label="Upload" />
            <x-jetax-progress :value="80" label="Download" color="success" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Animado --}}
    <x-jetax-docs-preview-section title="Animado (Striped)" :code="$codeAnimated">
        <div class="w-full space-y-3">
            <x-jetax-progress :value="65" :animated="true" />
            <x-jetax-progress :value="45" :animated="true" color="success" />
        </div>
    </x-jetax-docs-preview-section>

</div>
