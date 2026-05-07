<?php

it('test_renders_textarea_element', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" />');

    $view->assertSee('<textarea', false);
});

it('test_rows_attribute_set', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" :rows="6" />');

    $view->assertSee('rows="6"', false);
});

it('test_auto_resize_directive_present', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" :auto-resize="true" />');

    $view->assertSee('x-on:input', false);
});

it('test_default_rows_attribute', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" />');

    $view->assertSee('rows="4"', false);
});

it('test_default_background_class', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" />');

    $view->assertSee('f3f3ff', false);
});

it('test_default_border_class', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" />');

    $view->assertSee('e2e6f1', false);
});

it('test_error_state_applied', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" state="error" />');

    $view->assertSee('bg-red-50', false);
    $view->assertSee('border-red-500', false);
});

it('test_disabled_state_applied', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" disabled />');

    $view->assertSee('disabled', false);
    $view->assertSee('bg-slate-100', false);
});

it('test_label_rendered_with_correct_styles', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" label="Descrição" />');

    $view->assertSee('uppercase', false);
    $view->assertSee('tracking-wider', false);
    $view->assertSee('Descrição', false);
});

it('test_wire_model_attribute_preserved', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" wire:model="descricao" />');

    $view->assertSee('wire:model', false);
});

it('test_no_auto_resize_without_prop', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" />');

    $view->assertDontSee('x-on:input', false);
});
