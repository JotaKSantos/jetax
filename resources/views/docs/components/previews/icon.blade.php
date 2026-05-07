@php
$codeBasico = <<<'BLADE'
<div class="flex items-center gap-4">
    <x-jetax-icon name="home" />
    <x-jetax-icon name="search" />
    <x-jetax-icon name="settings" />
    <x-jetax-icon name="favorite" />
    <x-jetax-icon name="delete" />
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

$codePeso = <<<'BLADE'
<div class="flex items-center gap-4">
    <x-jetax-icon name="settings" :weight="100" />
    <x-jetax-icon name="settings" :weight="300" />
    <x-jetax-icon name="settings" :weight="400" />
    <x-jetax-icon name="settings" :weight="700" />
</div>
BLADE;

$codeFill = <<<'BLADE'
<div class="flex items-center gap-4">
    <x-jetax-icon name="favorite" />
    <x-jetax-icon name="favorite" :fill="true" />
</div>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <div class="flex items-center gap-4">
            <x-jetax-icon name="home" />
            <x-jetax-icon name="search" />
            <x-jetax-icon name="settings" />
            <x-jetax-icon name="favorite" />
            <x-jetax-icon name="delete" />
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

    {{-- Peso (Weight) --}}
    <x-jetax-docs-preview-section title="Peso (Weight)" :code="$codePeso">
        <div class="flex items-center gap-4">
            <x-jetax-icon name="settings" :weight="100" />
            <x-jetax-icon name="settings" :weight="300" />
            <x-jetax-icon name="settings" :weight="400" />
            <x-jetax-icon name="settings" :weight="700" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Preenchido (Fill) --}}
    <x-jetax-docs-preview-section title="Preenchido (Fill)" :code="$codeFill">
        <div class="flex items-center gap-4">
            <x-jetax-icon name="favorite" />
            <x-jetax-icon name="favorite" :fill="true" />
        </div>
    </x-jetax-docs-preview-section>

</div>
