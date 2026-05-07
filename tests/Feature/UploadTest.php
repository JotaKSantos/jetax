<?php

it('test_renders_dropzone', function () {
    $view = $this->blade('<x-jetax-upload />');

    $view->assertSee('data-dropzone', false);
});

it('test_accept_attribute_applied', function () {
    $view = $this->blade('<x-jetax-upload accept="image/*" />');

    $view->assertSee('accept="image/*"', false);
});

it('test_multiple_attribute_when_prop_true', function () {
    $view = $this->blade('<x-jetax-upload :multiple="true" />');

    $view->assertSee('multiple', false);
});

it('test_wire_model_passthrough', function () {
    $view = $this->blade('<x-jetax-upload wire:model="foto" />');

    $view->assertSee('wire:model', false);
});
