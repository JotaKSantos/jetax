@php
$codeBasico = <<<'BLADE'
<div class="flex items-center gap-4">
    <x-jetax-icon name="house" />
    <x-jetax-icon name="magnifying-glass" />
    <x-jetax-icon name="gear" />
    <x-jetax-icon name="heart" />
    <x-jetax-icon name="trash" />
</div>
BLADE;

$codeTamanhos = <<<'BLADE'
<div class="flex items-end gap-4">
    <x-jetax-icon name="star" size="sm" />
    <x-jetax-icon name="star" size="md" />
    <x-jetax-icon name="star" size="lg" />
    <x-jetax-icon name="star" size="xl" />
    <x-jetax-icon name="star" :size="48" />
</div>
BLADE;

$codeEstilos = <<<'BLADE'
<div class="flex items-center gap-4">
    <x-jetax-icon name="bell" />
    <x-jetax-icon name="bell" variant="regular" />
    <x-jetax-icon name="brands:whatsapp" />
</div>
BLADE;

$codePrefixo = <<<'BLADE'
<div class="flex items-center gap-4">
    <x-jetax-icon name="heart" />
    <x-jetax-icon name="regular:heart" />
</div>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <div class="flex items-center gap-4">
            <x-jetax-icon name="house" />
            <x-jetax-icon name="magnifying-glass" />
            <x-jetax-icon name="gear" />
            <x-jetax-icon name="heart" />
            <x-jetax-icon name="trash" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Tamanhos --}}
    <x-jetax-docs-preview-section title="Tamanhos" :code="$codeTamanhos">
        <div class="flex items-end gap-4">
            <x-jetax-icon name="star" size="sm" />
            <x-jetax-icon name="star" size="md" />
            <x-jetax-icon name="star" size="lg" />
            <x-jetax-icon name="star" size="xl" />
            <x-jetax-icon name="star" :size="48" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Estilos (variant) --}}
    <x-jetax-docs-preview-section title="Estilos (variant)" :code="$codeEstilos">
        <div class="flex items-center gap-4">
            <x-jetax-icon name="bell" />
            <x-jetax-icon name="bell" variant="regular" />
            <x-jetax-icon name="brands:whatsapp" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Prefixo de estilo no nome --}}
    <x-jetax-docs-preview-section title="Prefixo de estilo no nome" :code="$codePrefixo">
        <div class="flex items-center gap-4">
            <x-jetax-icon name="heart" />
            <x-jetax-icon name="regular:heart" />
        </div>
    </x-jetax-docs-preview-section>

</div>
