<?php

it('test_title_rendered_with_headline_font', function () {
    $view = $this->blade('<x-jetax-page-header title="Clientes" />');

    $view->assertSee('Clientes');
    $view->assertSee('font-headline', false);
});

it('test_subtitle_rendered_with_muted_class', function () {
    $view = $this->blade('<x-jetax-page-header title="Clientes" subtitle="Gerenciar base de clientes" />');

    $view->assertSee('Gerenciar base de clientes');
    $view->assertSee('text-slate-500', false);
});

it('test_actions_slot_rendered_right', function () {
    $view = $this->blade('
        <x-jetax-page-header title="Clientes">
            <x-slot:actions>
                <button class="btn-primary">Novo Cliente</button>
            </x-slot:actions>
        </x-jetax-page-header>
    ');

    $view->assertSee('Novo Cliente');
    $view->assertSee('btn-primary', false);
});

it('test_breadcrumbs_rendered_when_prop_provided', function () {
    $breadcrumbs = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Clientes'],
    ];

    $view = $this->blade('<x-jetax-page-header title="Clientes" :breadcrumbs="$breadcrumbs" />', [
        'breadcrumbs' => $breadcrumbs,
    ]);

    $view->assertSee('Home');
    $view->assertSee('Clientes');
    $view->assertSee('aria-label="Breadcrumb"', false);
});

it('test_no_breadcrumbs_when_empty', function () {
    $view = $this->blade('<x-jetax-page-header title="Dashboard" />');

    $view->assertDontSee('aria-label="Breadcrumb"', false);
});

it('test_no_subtitle_when_not_provided', function () {
    $view = $this->blade('<x-jetax-page-header title="Dashboard" />');

    $view->assertDontSee('text-slate-500', false);
});
