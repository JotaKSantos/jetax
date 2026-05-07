<?php

it('test_renders_svg_or_animated_element', function () {
    $view = $this->blade('<x-jetax-spinner />');

    $view->assertSee('animate-spin', false);
});

it('test_size_classes_applied', function () {
    $sm = $this->blade('<x-jetax-spinner size="sm" />');
    $md = $this->blade('<x-jetax-spinner size="md" />');
    $lg = $this->blade('<x-jetax-spinner size="lg" />');

    $sm->assertSee('h-4 w-4', false);
    $md->assertSee('h-8 w-8', false);
    $lg->assertSee('h-12 w-12', false);

    $sm->assertDontSee('h-8 w-8', false);
    $lg->assertDontSee('h-8 w-8', false);
});

it('test_wire_loading_attribute_passthrough', function () {
    $view = $this->blade('<x-jetax-spinner wire:loading />');

    $view->assertSee('wire:loading', false);
});
