<?php

use Illuminate\Support\Facades\Blade;
use Jetax\DesignSystem\View\Components\Select;

it('test_renders_options_from_prop', function () {
    $view = $this->blade('<x-jetax-select name="origem" :options="[\'google\' => \'Google Ads\', \'email\' => \'E-mail Marketing\']" />');

    $view->assertSee('<option', false);
    $view->assertSee('Google Ads', false);
    $view->assertSee('E-mail Marketing', false);
});

it('test_placeholder_option_rendered', function () {
    $view = $this->blade('<x-jetax-select name="origem" placeholder="Selecione uma opção" />');

    $view->assertSee('<option value="">', false);
    $view->assertSee('Selecione uma opção', false);
});

it('test_error_class_applied', function () {
    $view = $this->withViewErrors(['campo' => ['Campo obrigatório']])
        ->blade('<x-jetax-select name="campo" />');

    $view->assertSee('border-error', false);
    $view->assertDontSee('bg-red-50', false);
});

it('test_slot_options_rendered', function () {
    $view = $this->blade(
        '<x-jetax-select name="status"><option value="ativo">Ativo</option><option value="inativo">Inativo</option></x-jetax-select>'
    );

    $view->assertSee('<option value="ativo">', false);
    $view->assertSee('Ativo', false);
    $view->assertSee('<option value="inativo">', false);
    $view->assertSee('Inativo', false);
});

it('test_consumer_class_reaches_select_element', function () {
    $html = Blade::render('<x-jetax-select name="especie" class="w-40" />');

    expect(tagClass(htmlTag($html, 'select')))->toContain('w-40');
    expect(tagClass(htmlTag($html, 'div')))->not->toContain('w-40');
});

it('test_height_is_40px_by_class_without_inline_style', function () {
    $html = Blade::render('<x-jetax-select name="especie" />');

    expect(tagClass(htmlTag($html, 'select')))->toContain('h-10');
    expect($html)->not->toContain('style="height:');
});

it('test_select_reserves_arrow_gutter', function () {
    $html = Blade::render('<x-jetax-select name="especie" />');

    expect(tagClass(htmlTag($html, 'select')))->toContain('pr-9');
});

it('test_error_classes_use_tokens', function () {
    $select = new Select(name: 'especie');

    expect($select->selectClasses(true))
        ->toContain('border-error')
        ->not->toContain('bg-red-50');
});

it('test_label_uses_design_metric_and_token', function () {
    $html = Blade::render('<x-jetax-select name="especie" label="Espécie" />');

    expect(tagClass(htmlTag($html, 'label')))
        ->toContain('text-[11px]')
        ->toContain('font-bold')
        ->toContain('tracking-[.06em]')
        ->toContain('text-on-surface-variant');
    expect($html)->not->toContain('text-[#')->not->toContain('#f3f3ff')->not->toContain('#0061a5');
});

it('test_id_is_deterministic', function () {
    $named = Blade::render('<x-jetax-select name="especie" label="Espécie" />');

    expect($named)->toContain('id="select_especie"')->toContain('for="select_especie"');

    $first = Blade::render('<x-jetax-select label="Espécie" placeholder="Selecione" />');
    $second = Blade::render('<x-jetax-select label="Espécie" placeholder="Selecione" />');

    preg_match('/id="(select_[0-9a-f]{8})"/', $first, $match);

    expect($match)->not->toBeEmpty();
    expect($second)->toContain('id="'.$match[1].'"');
});
