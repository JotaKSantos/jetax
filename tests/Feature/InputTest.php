<?php

use Illuminate\Support\Facades\Blade;
use Jetax\DesignSystem\View\Components\Input;

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

    $view->assertSee('border-error', false);
    $view->assertSee('bg-error-container/30', false);
    $view->assertDontSee('bg-red-50', false);
});

it('test_warning_state_applied', function () {
    $view = $this->blade('<x-jetax-input name="campo" state="warning" />');

    $view->assertSee('border-warning', false);
    $view->assertDontSee('bg-amber-50', false);
});

it('test_success_state_applied', function () {
    $view = $this->blade('<x-jetax-input name="campo" state="success" />');

    $view->assertSee('border-success', false);
    $view->assertDontSee('bg-green-50', false);
});

it('test_readonly_state_applied', function () {
    $view = $this->blade('<x-jetax-input name="campo" :readonly="true" />');

    $view->assertSee('bg-surface-container-low', false);
    $view->assertSee('text-on-surface/40', false);
});

it('test_label_rendered_with_correct_styles', function () {
    $view = $this->blade('<x-jetax-input name="campo" label="Nome Completo" />');

    $view->assertSee('uppercase', false);
    $view->assertSee('tracking-[.06em]', false);
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

it('test_consumer_class_reaches_input_element', function () {
    $html = Blade::render('<x-jetax-input name="cpf" class="font-mono" />');

    expect(tagClass(htmlTag($html, 'input')))->toContain('font-mono');
    expect(tagClass(htmlTag($html, 'div')))->not->toContain('font-mono');
});

it('test_height_is_40px_by_class_without_inline_style', function () {
    $html = Blade::render('<x-jetax-input name="campo" />');

    expect(tagClass(htmlTag($html, 'input')))->toContain('h-10');
    expect($html)->not->toContain('style="height:');
});

it('test_error_classes_use_tokens', function () {
    $input = new Input(name: 'campo');

    expect($input->inputClasses(true))
        ->toContain('border-error')
        ->not->toContain('bg-red-50')
        ->not->toContain('red-500');
});

it('test_label_uses_design_metric_and_token', function () {
    $html = Blade::render('<x-jetax-input name="campo" label="Nome" />');
    $label = tagClass(htmlTag($html, 'label'));

    expect($label)
        ->toContain('text-[11px]')
        ->toContain('font-bold')
        ->toContain('tracking-[.06em]')
        ->toContain('text-on-surface-variant');
    expect($html)->not->toContain('text-[#');
});

it('test_id_is_deterministic', function () {
    $named = Blade::render('<x-jetax-input name="cpf" label="CPF" />');

    expect($named)->toContain('id="input_cpf"')->toContain('for="input_cpf"');

    $first = Blade::render('<x-jetax-input label="Busca" placeholder="Pesquisar" />');
    $second = Blade::render('<x-jetax-input label="Busca" placeholder="Pesquisar" />');

    preg_match('/id="(input_[0-9a-f]{8})"/', $first, $match);

    expect($match)->not->toBeEmpty();
    expect($second)->toContain('id="'.$match[1].'"');
});
