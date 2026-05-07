<?php

it('test_renders_input_for_tag_entry', function () {
    $view = $this->blade('<x-jetax-tag />');

    $view->assertSee('type="text"', false);
    $view->assertSee('Adicionar tag...', false);
});

it('test_wire_model_on_hidden_array_input', function () {
    $view = $this->blade('<x-jetax-tag wire:model="tags" />');

    $view->assertSee('wire:model', false);
    $view->assertSee('type="hidden"', false);
});

it('test_disabled_state_blocks_input', function () {
    $view = $this->blade('<x-jetax-tag :disabled="true" />');

    $view->assertSee('disabled', false);
});
