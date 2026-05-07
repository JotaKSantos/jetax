<?php

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

    $view->assertSee('bg-red-50', false);
    $view->assertSee('border-red-500', false);
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
