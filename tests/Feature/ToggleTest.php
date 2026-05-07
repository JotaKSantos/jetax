<?php

it('test_renders_toggle_with_alpine_state', function () {
    $view = $this->blade('<x-jetax-toggle />');

    $view->assertSee('x-data', false);
});

it('test_label_rendered', function () {
    $view = $this->blade('<x-jetax-toggle label="Ativar notificações" />');

    $view->assertSee('Ativar notificações');
});

it('test_initial_state_off_by_default', function () {
    $view = $this->blade('<x-jetax-toggle />');

    $view->assertSee("{ on: false }", false);
});
