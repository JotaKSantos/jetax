<?php

it('test_last_item_has_no_link', function () {
    $items = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Clientes', 'url' => '/clientes'],
        ['label' => 'Detalhes'],
    ];

    $view = $this->blade('<x-jetax-breadcrumbs :items="$items" />', ['items' => $items]);

    // O último item "Detalhes" deve aparecer em um <span>, não em um <a>
    $view->assertSee('Detalhes', false);
    $view->assertDontSee('<a href="#">Detalhes</a>', false);
    $view->assertDontSee('<a href="">Detalhes</a>', false);
    // Garante que "Detalhes" aparece como span de item atual
    $view->assertSee('font-semibold">Detalhes', false);
});

it('test_other_items_have_links', function () {
    $items = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Clientes', 'url' => '/clientes'],
        ['label' => 'Detalhes'],
    ];

    $view = $this->blade('<x-jetax-breadcrumbs :items="$items" />', ['items' => $items]);

    $view->assertSee('<a href="/"', false);
    $view->assertSee('<a href="/clientes"', false);
    $view->assertSee('Home', false);
    $view->assertSee('Clientes', false);
});

it('test_separator_is_chevron', function () {
    $items = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Detalhes'],
    ];

    $view = $this->blade('<x-jetax-breadcrumbs :items="$items" />', ['items' => $items]);

    // O separador deve usar o ícone Material Symbols "chevron_right"
    $view->assertSee('chevron_right', false);
    // O separador não deve ser uma barra literal entre os textos dos itens
    $view->assertDontSee('Home / Detalhes', false);
    $view->assertDontSee('>/<', false);
});

it('test_truncates_on_mobile', function () {
    $items = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Financeiro', 'url' => '/financeiro'],
        ['label' => 'Invoices', 'url' => '/invoices'],
        ['label' => 'Detalhes'],
    ];

    $view = $this->blade('<x-jetax-breadcrumbs :items="$items" />', ['items' => $items]);

    // Com 4 itens, deve conter o indicador de truncamento "…"
    $view->assertSee('…', false);

    // Deve usar classes para controle mobile/desktop
    $view->assertSee('hidden md:flex', false);
    $view->assertSee('md:hidden', false);
});
