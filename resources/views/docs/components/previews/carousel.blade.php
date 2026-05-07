@php
$codeBasico = <<<'BLADE'
<x-jetax-carousel>
    <x-jetax-carousel-item>
        <div class="h-48 bg-primary flex items-center justify-center rounded-lg">
            <span class="text-white text-lg font-semibold">Slide 1</span>
        </div>
    </x-jetax-carousel-item>
    <x-jetax-carousel-item>
        <div class="h-48 bg-success flex items-center justify-center rounded-lg">
            <span class="text-white text-lg font-semibold">Slide 2</span>
        </div>
    </x-jetax-carousel-item>
    <x-jetax-carousel-item>
        <div class="h-48 bg-warning flex items-center justify-center rounded-lg">
            <span class="text-white text-lg font-semibold">Slide 3</span>
        </div>
    </x-jetax-carousel-item>
</x-jetax-carousel>
BLADE;

$codeAutoplay = <<<'BLADE'
<x-jetax-carousel :autoplay="true" :interval="3000">
    <x-jetax-carousel-item>
        <div class="h-48 bg-primary flex items-center justify-center rounded-lg">
            <span class="text-white text-lg font-semibold">Slide 1</span>
        </div>
    </x-jetax-carousel-item>
    <x-jetax-carousel-item>
        <div class="h-48 bg-success flex items-center justify-center rounded-lg">
            <span class="text-white text-lg font-semibold">Slide 2</span>
        </div>
    </x-jetax-carousel-item>
    <x-jetax-carousel-item>
        <div class="h-48 bg-warning flex items-center justify-center rounded-lg">
            <span class="text-white text-lg font-semibold">Slide 3</span>
        </div>
    </x-jetax-carousel-item>
</x-jetax-carousel>
BLADE;

$codeFade = <<<'BLADE'
<x-jetax-carousel transition="fade">
    <x-jetax-carousel-item>
        <div class="h-48 bg-danger flex items-center justify-center rounded-lg">
            <span class="text-white text-lg font-semibold">Slide 1</span>
        </div>
    </x-jetax-carousel-item>
    <x-jetax-carousel-item>
        <div class="h-48 bg-info flex items-center justify-center rounded-lg">
            <span class="text-white text-lg font-semibold">Slide 2</span>
        </div>
    </x-jetax-carousel-item>
    <x-jetax-carousel-item>
        <div class="h-48 bg-secondary flex items-center justify-center rounded-lg">
            <span class="text-white text-lg font-semibold">Slide 3</span>
        </div>
    </x-jetax-carousel-item>
</x-jetax-carousel>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <x-jetax-carousel>
            <x-jetax-carousel-item>
                <div class="h-48 bg-primary flex items-center justify-center rounded-lg">
                    <span class="text-white text-lg font-semibold">Slide 1</span>
                </div>
            </x-jetax-carousel-item>
            <x-jetax-carousel-item>
                <div class="h-48 bg-success flex items-center justify-center rounded-lg">
                    <span class="text-white text-lg font-semibold">Slide 2</span>
                </div>
            </x-jetax-carousel-item>
            <x-jetax-carousel-item>
                <div class="h-48 bg-warning flex items-center justify-center rounded-lg">
                    <span class="text-white text-lg font-semibold">Slide 3</span>
                </div>
            </x-jetax-carousel-item>
        </x-jetax-carousel>
    </x-jetax-docs-preview-section>

    {{-- Autoplay --}}
    <x-jetax-docs-preview-section title="Autoplay" :code="$codeAutoplay">
        <x-jetax-carousel :autoplay="true" :interval="3000">
            <x-jetax-carousel-item>
                <div class="h-48 bg-primary flex items-center justify-center rounded-lg">
                    <span class="text-white text-lg font-semibold">Slide 1</span>
                </div>
            </x-jetax-carousel-item>
            <x-jetax-carousel-item>
                <div class="h-48 bg-success flex items-center justify-center rounded-lg">
                    <span class="text-white text-lg font-semibold">Slide 2</span>
                </div>
            </x-jetax-carousel-item>
            <x-jetax-carousel-item>
                <div class="h-48 bg-warning flex items-center justify-center rounded-lg">
                    <span class="text-white text-lg font-semibold">Slide 3</span>
                </div>
            </x-jetax-carousel-item>
        </x-jetax-carousel>
    </x-jetax-docs-preview-section>

    {{-- Transicao Fade --}}
    <x-jetax-docs-preview-section title="Transicao Fade" :code="$codeFade">
        <x-jetax-carousel transition="fade">
            <x-jetax-carousel-item>
                <div class="h-48 bg-danger flex items-center justify-center rounded-lg">
                    <span class="text-white text-lg font-semibold">Slide 1</span>
                </div>
            </x-jetax-carousel-item>
            <x-jetax-carousel-item>
                <div class="h-48 bg-info flex items-center justify-center rounded-lg">
                    <span class="text-white text-lg font-semibold">Slide 2</span>
                </div>
            </x-jetax-carousel-item>
            <x-jetax-carousel-item>
                <div class="h-48 bg-secondary flex items-center justify-center rounded-lg">
                    <span class="text-white text-lg font-semibold">Slide 3</span>
                </div>
            </x-jetax-carousel-item>
        </x-jetax-carousel>
    </x-jetax-docs-preview-section>

</div>
