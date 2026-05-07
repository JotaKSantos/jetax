<?php

it('test_all_variants_render', function () {
    $variants = ['primary', 'info', 'success', 'warning', 'danger'];

    foreach ($variants as $variant) {
        $view = $this->blade('<x-jetax-alert message="Mensagem de teste" :variant="$variant" />', ['variant' => $variant]);

        $view->assertSee('Mensagem de teste');
    }
});

it('test_soft_style_has_light_bg', function () {
    $view = $this->blade('<x-jetax-alert message="Alerta soft" variant="primary" style="soft" />');

    $view->assertSee('bg-primary/10', false);
});

it('test_solid_style_has_full_bg', function () {
    $view = $this->blade('<x-jetax-alert message="Alerta solid" variant="primary" style="solid" />');

    $view->assertSee('bg-primary', false);
    $view->assertSee('text-white', false);
});

it('test_rich_style_has_left_border', function () {
    $view = $this->blade('<x-jetax-alert message="Alerta rich" variant="primary" style="rich" />');

    $view->assertSee('border-l-4', false);
});

it('test_dismissible_has_close_button', function () {
    $view = $this->blade('<x-jetax-alert message="Alerta dismissivel" :dismissible="true" />');

    $view->assertSee('close', false);
    $view->assertSee('x-on:click', false);
});

it('test_hidden_when_no_message', function () {
    $view = $this->blade('<x-jetax-alert :message="null" />');

    $view->assertDontSee('role="alert"', false);
});
