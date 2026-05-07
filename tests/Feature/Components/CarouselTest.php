<?php

use Jetax\DesignSystem\View\Components\Carousel;
use Jetax\DesignSystem\View\Components\CarouselItem;

it('renders carousel items', function () {
    $view = $this->blade('
        <x-jetax-carousel>
            <x-jetax-carousel-item>Slide 1</x-jetax-carousel-item>
            <x-jetax-carousel-item>Slide 2</x-jetax-carousel-item>
        </x-jetax-carousel>
    ');
    $view->assertSee('Slide 1', false);
    $view->assertSee('Slide 2', false);
});

it('renders dot indicators', function () {
    $view = $this->blade('
        <x-jetax-carousel>
            <x-jetax-carousel-item>Slide 1</x-jetax-carousel-item>
            <x-jetax-carousel-item>Slide 2</x-jetax-carousel-item>
            <x-jetax-carousel-item>Slide 3</x-jetax-carousel-item>
        </x-jetax-carousel>
    ');
    // Should have indicator container
    $view->assertSee('carousel-indicator', false);
});

it('renders prev and next controls', function () {
    $view = $this->blade('
        <x-jetax-carousel>
            <x-jetax-carousel-item>Slide 1</x-jetax-carousel-item>
        </x-jetax-carousel>
    ');
    $view->assertSee('chevron_left', false);
    $view->assertSee('chevron_right', false);
});

it('reflects autoplay prop in alpine data', function () {
    $view = $this->blade('<x-jetax-carousel :autoplay="true">
        <x-jetax-carousel-item>Slide 1</x-jetax-carousel-item>
    </x-jetax-carousel>');
    $view->assertSee('autoplay: true', false);
});
