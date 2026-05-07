<?php

it('test_renders_editor_container', function () {
    $view = $this->blade('<x-jetax-editor />');

    $view->assertSee('data-editor-container', false);
});

it('test_toolbar_buttons_present', function () {
    $view = $this->blade('<x-jetax-editor />');

    $view->assertSee('data-editor-toolbar', false);
    $view->assertSee('data-action="bold"', false);
    $view->assertSee('data-action="italic"', false);
    $view->assertSee('data-action="orderedList"', false);
});

it('test_wire_model_hidden_input', function () {
    $view = $this->blade('<x-jetax-editor wire:model="conteudo" />');

    $view->assertSee('type="hidden"', false);
    $view->assertSee('wire:model', false);
});

it('test_placeholder_applied', function () {
    $view = $this->blade('<x-jetax-editor placeholder="Digite aqui..." />');

    $view->assertSee('data-placeholder="Digite aqui..."', false);
});
