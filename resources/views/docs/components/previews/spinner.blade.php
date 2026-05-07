@php
$colors = ['primary', 'secondary', 'success', 'info', 'warning', 'danger'];

$codeColors = implode("\n", array_map(fn($c) => '<x-jetax-spinner color="' . $c . '" />', $colors));

$codeSizes = <<<'BLADE'
<x-jetax-spinner size="sm" />
<x-jetax-spinner size="md" />
<x-jetax-spinner size="lg" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Cores --}}
    <x-jetax-docs-preview-section title="Cores" :code="$codeColors">
        @foreach($colors as $color)
            <x-jetax-spinner :color="$color" />
        @endforeach
    </x-jetax-docs-preview-section>

    {{-- Tamanhos --}}
    <x-jetax-docs-preview-section title="Tamanhos" :code="$codeSizes">
        <x-jetax-spinner size="sm" />
        <x-jetax-spinner size="md" />
        <x-jetax-spinner size="lg" />
    </x-jetax-docs-preview-section>

</div>
