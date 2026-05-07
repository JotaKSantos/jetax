@php
$codeWidths = <<<'BLADE'
<x-jetax-skeleton width="full" />
<x-jetax-skeleton width="3/4" />
<x-jetax-skeleton width="1/2" />
<x-jetax-skeleton width="1/3" />
BLADE;

$codeHeights = <<<'BLADE'
<x-jetax-skeleton height="2" />
<x-jetax-skeleton height="4" />
<x-jetax-skeleton height="8" />
<x-jetax-skeleton height="16" />
BLADE;

$codeRounded = <<<'BLADE'
<x-jetax-skeleton width="16" height="16" :rounded="true" />
<x-jetax-skeleton width="24" height="24" :rounded="true" />
<x-jetax-skeleton width="32" height="6" :rounded="true" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Larguras --}}
    <x-jetax-docs-preview-section title="Larguras" :code="$codeWidths">
        <div class="w-full space-y-2">
            <x-jetax-skeleton width="full" />
            <x-jetax-skeleton width="3/4" />
            <x-jetax-skeleton width="1/2" />
            <x-jetax-skeleton width="1/3" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Alturas --}}
    <x-jetax-docs-preview-section title="Alturas" :code="$codeHeights">
        <div class="w-full space-y-2">
            <x-jetax-skeleton height="2" />
            <x-jetax-skeleton height="4" />
            <x-jetax-skeleton height="8" />
            <x-jetax-skeleton height="16" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Arredondado --}}
    <x-jetax-docs-preview-section title="Arredondado" :code="$codeRounded">
        <x-jetax-skeleton width="16" height="16" :rounded="true" />
        <x-jetax-skeleton width="24" height="24" :rounded="true" />
        <x-jetax-skeleton width="32" height="6" :rounded="true" />
    </x-jetax-docs-preview-section>

</div>
