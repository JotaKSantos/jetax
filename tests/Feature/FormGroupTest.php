<?php

it('test_label_rendered', function () {
    $view = $this->blade('<x-jetax-form-group name="email" label="Endereço de E-mail" />');

    $view->assertSee('Endereço de E-mail');
});

it('test_required_asterisk_shown', function () {
    $view = $this->blade('<x-jetax-form-group name="email" label="E-mail" :required="true" />');

    $view->assertSee('*');
    $view->assertSee('text-red-500', false);
});

it('test_hint_rendered', function () {
    $view = $this->blade('<x-jetax-form-group name="email" label="E-mail" hint="Informe um e-mail válido" />');

    $view->assertSee('Informe um e-mail válido');
});

it('test_error_message_from_error_bag', function () {
    $view = $this->withViewErrors(['email' => 'O campo email é obrigatório'])
        ->blade('<x-jetax-form-group name="email" label="E-mail" />');

    $view->assertSee('O campo email é obrigatório');
    $view->assertSee('text-red-600', false);
});

it('test_no_error_when_bag_is_empty', function () {
    $view = $this->blade('<x-jetax-form-group name="email" label="E-mail" />');

    $view->assertDontSee('text-red-600', false);
});
