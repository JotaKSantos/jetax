<?php

it('test_correct_number_of_inputs_rendered', function () {
    $view = $this->blade('<x-jetax-pin :length="4" />');

    $html = (string) $view;

    expect(substr_count($html, 'maxlength="1"'))->toBe(4);
});

it('test_alpine_focus_directive_present', function () {
    $view = $this->blade('<x-jetax-pin />');

    $view->assertSee('x-on:input', false);
    $view->assertSee('x-data', false);
});

it('test_wire_model_on_hidden_input', function () {
    $view = $this->blade('<x-jetax-pin wire:model="pinCode" />');

    $view->assertSee('wire:model', false);
    $view->assertSee('type="hidden"', false);
});

it('test_default_length_is_six', function () {
    $view = $this->blade('<x-jetax-pin />');

    $html = (string) $view;

    expect(substr_count($html, 'maxlength="1"'))->toBe(6);
});

it('test_numeric_type_sets_inputmode', function () {
    $view = $this->blade('<x-jetax-pin type="numeric" />');

    $view->assertSee('inputmode="numeric"', false);
});

it('test_alphanumeric_type_sets_inputmode', function () {
    $view = $this->blade('<x-jetax-pin type="alphanumeric" />');

    $view->assertSee('inputmode="text"', false);
});
