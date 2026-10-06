<?php

use Illuminate\Support\Facades\Blade;

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

    $view->assertSee('bg-surface-input', false);
});

it('test_default_border_class', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" />');

    $view->assertSee('border-outline-variant', false);
});

it('test_error_state_applied', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" state="error" />');

    $view->assertSee('border-error', false);
    $view->assertDontSee('bg-red-50', false);
});

it('test_disabled_state_applied', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" disabled />');

    $view->assertSee('disabled', false);
    $view->assertSee('bg-surface-container-low', false);
});

it('test_label_rendered_with_correct_styles', function () {
    $view = $this->blade('<x-jetax-textarea name="descricao" label="Descrição" />');

    $view->assertSee('uppercase', false);
    $view->assertSee('tracking-[.06em]', false);
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

it('test_consumer_class_reaches_textarea_element', function () {
    $html = Blade::render('<x-jetax-textarea name="obs" class="font-mono" />');

    expect(tagClass(htmlTag($html, 'textarea')))->toContain('font-mono');
    expect(tagClass(htmlTag($html, 'div')))->not->toContain('font-mono');
});

it('test_does_not_emit_inline_height', function () {
    $html = Blade::render('<x-jetax-textarea name="obs" />');

    expect($html)->not->toContain('style="height:');
});

it('test_label_uses_design_metric_and_token', function () {
    $html = Blade::render('<x-jetax-textarea name="obs" label="Observações" />');

    expect(tagClass(htmlTag($html, 'label')))
        ->toContain('text-[11px]')
        ->toContain('font-bold')
        ->toContain('tracking-[.06em]')
        ->toContain('text-on-surface-variant');
    expect($html)->not->toContain('text-[#');
});

it('test_id_is_deterministic', function () {
    $named = Blade::render('<x-jetax-textarea name="obs" label="Observações" />');

    expect($named)->toContain('id="textarea_obs"')->toContain('for="textarea_obs"');

    $first = Blade::render('<x-jetax-textarea label="Observações" />');
    $second = Blade::render('<x-jetax-textarea label="Observações" />');

    preg_match('/id="(textarea_[0-9a-f]{8})"/', $first, $match);

    expect($match)->not->toBeEmpty();
    expect($second)->toContain('id="'.$match[1].'"');
});
