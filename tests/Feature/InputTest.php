<?php

it('test_renders_input_element', function () {
    $view = $this->blade('<x-jetax-input name="campo" />');

    $view->assertSee('<input', false);
});

it('test_default_background_class', function () {
    $view = $this->blade('<x-jetax-input name="campo" />');

    $view->assertSee('bg-surface-input', false);
});

it('test_default_border_class', function () {
    $view = $this->blade('<x-jetax-input name="campo" />');

    $view->assertSee('border-outline-variant', false);
});

it('test_error_state_applied', function () {
    // Simula $errors->has('campo') via state prop
    $view = $this->blade('<x-jetax-input name="campo" state="error" />');

    $view->assertSee('bg-red-50', false);
    $view->assertSee('border-red-500', false);
});

it('test_warning_state_applied', function () {
    $view = $this->blade('<x-jetax-input name="campo" state="warning" />');

    $view->assertSee('bg-amber-50', false);
    $view->assertSee('border-amber-500', false);
});

it('test_success_state_applied', function () {
    $view = $this->blade('<x-jetax-input name="campo" state="success" />');

    $view->assertSee('bg-green-50', false);
    $view->assertSee('border-green-500', false);
});

it('test_readonly_state_applied', function () {
    $view = $this->blade('<x-jetax-input name="campo" :readonly="true" />');

    $view->assertSee('bg-surface-container-low', false);
    $view->assertSee('text-on-surface/40', false);
});

it('test_label_rendered_with_correct_styles', function () {
    $view = $this->blade('<x-jetax-input name="campo" label="Nome Completo" />');

    $view->assertSee('uppercase', false);
    $view->assertSee('tracking-wider', false);
    $view->assertSee('Nome Completo', false);
});

it('test_type_attribute_passthrough', function () {
    $view = $this->blade('<x-jetax-input name="email" type="email" />');

    $view->assertSee('type="email"', false);
});

it('test_wire_model_attribute_preserved', function () {
    $view = $this->blade('<x-jetax-input name="campo" wire:model="campo" />');

    $view->assertSee('wire:model', false);
});

it('test_icon_rendered_when_prop_provided', function () {
    $view = $this->blade('<x-jetax-input name="campo" icon="search" />');

    $view->assertSee('material-symbols-outlined', false);
    $view->assertSee('search', false);
});

it('test_mask_directive_applied_when_prop_present', function () {
    $view = $this->blade('<x-jetax-input name="cpf" mask="cpf" />');

    $view->assertSee('x-mask', false);
});

it('test_no_mask_directive_without_prop', function () {
    $view = $this->blade('<x-jetax-input name="campo" />');

    $view->assertDontSee('x-mask', false);
});
