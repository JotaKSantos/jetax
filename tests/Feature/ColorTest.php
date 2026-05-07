<?php

it('test_renders_color_input', function () {
    $view = $this->blade('<x-jetax-color />');

    $view->assertSee('type="color"', false);
});

it('test_preview_rendered', function () {
    $view = $this->blade('<x-jetax-color />');

    $view->assertSee('data-color-preview', false);
});

it('test_wire_model_passthrough', function () {
    $view = $this->blade('<x-jetax-color wire:model="selectedColor" />');

    $view->assertSee('wire:model', false);
});
