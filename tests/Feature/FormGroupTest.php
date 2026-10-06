<?php

use Illuminate\Support\Facades\Blade;

it('test_label_rendered', function () {
    $view = $this->blade('<x-jetax-form-group name="email" label="Endereço de E-mail" />');

    $view->assertSee('Endereço de E-mail');
});

it('test_required_asterisk_shown', function () {
    $view = $this->blade('<x-jetax-form-group name="email" label="E-mail" :required="true" />');

    $view->assertSee('*');
    $view->assertSee('text-error', false);
});

it('test_hint_rendered', function () {
    $view = $this->blade('<x-jetax-form-group name="email" label="E-mail" hint="Informe um e-mail válido" />');

    $view->assertSee('Informe um e-mail válido');
});

it('test_error_message_from_error_bag', function () {
    $view = $this->withViewErrors(['email' => 'O campo email é obrigatório'])
        ->blade('<x-jetax-form-group name="email" label="E-mail" />');

    $view->assertSee('O campo email é obrigatório');
    $view->assertSee('text-error', false);
});

it('test_no_error_when_bag_is_empty', function () {
    $view = $this->blade('<x-jetax-form-group name="email" label="E-mail" />');

    $view->assertDontSee('text-error', false);
});

it('test_label_uses_design_metric_and_token', function () {
    $html = Blade::render('<x-jetax-form-group name="email" label="E-mail" :required="true" />');

    expect(tagClass(htmlTag($html, 'label')))
        ->toContain('text-[11px]')
        ->toContain('font-bold')
        ->toContain('tracking-[.06em]')
        ->toContain('text-on-surface-variant');
    expect($html)->not->toContain('text-[#')->not->toContain('text-red-')->not->toContain('text-slate-');
});

/*
|--------------------------------------------------------------------------
| Campos sem hex (SPEC jetax-f1-alinhamento-v2, RF-11, RF-17)
|--------------------------------------------------------------------------
|
| Os arquivos de input, select, textarea, time e form-group não carregam
| utilitário de cor hexadecimal nem altura inline.
|
*/

dataset('field components', [
    'input' => ['input', 'Input'],
    'select' => ['select', 'Select'],
    'textarea' => ['textarea', 'Textarea'],
    'time' => ['time', 'Time'],
    'form-group' => ['form-group', 'FormGroup'],
]);

test('field component files have no hex color nor inline height', function (string $view, string $class): void {
    $root = __DIR__.'/../..';
    $contents = file_get_contents($root."/resources/views/components/{$view}.blade.php")
        .file_get_contents($root."/src/View/Components/{$class}.php");

    expect($contents)
        ->not->toContain('text-[#')
        ->not->toMatch('/(?:text|bg|border|ring|from|to|fill|stroke)-\[#/')
        ->not->toContain('style="height:')
        ->not->toContain('bg-red-50');
})->with('field components');
