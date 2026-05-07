<?php

it('test_first_tab_active_by_default', function () {
    $tabs = [
        ['name' => 'geral', 'label' => 'Dados Gerais'],
        ['name' => 'financeiro', 'label' => 'Financeiro'],
    ];

    $view = $this->blade('<x-jetax-tabs :tabs="$tabs" />', ['tabs' => $tabs]);

    $view->assertSee("activeTab: 'geral'", false);
});

it('test_underline_variant_classes', function () {
    $tabs = [
        ['name' => 'geral', 'label' => 'Dados Gerais'],
        ['name' => 'financeiro', 'label' => 'Financeiro'],
    ];

    $view = $this->blade('<x-jetax-tabs :tabs="$tabs" variant="underline" />', ['tabs' => $tabs]);

    $view->assertSee('border-b-2', false);
    $view->assertSee('border-primary', false);
});

it('test_pill_variant_classes', function () {
    $tabs = [
        ['name' => 'ativos', 'label' => 'Ativos'],
        ['name' => 'pendentes', 'label' => 'Pendentes'],
    ];

    $view = $this->blade('<x-jetax-tabs :tabs="$tabs" variant="pill" />', ['tabs' => $tabs]);

    $view->assertSee('rounded-full', false);
    $view->assertSee('bg-surface-container', false);
});

it('test_count_badge_rendered', function () {
    $tabs = [
        ['name' => 'geral', 'label' => 'Dados Gerais'],
        ['name' => 'financeiro', 'label' => 'Financeiro', 'count' => 5],
    ];

    $view = $this->blade('<x-jetax-tabs :tabs="$tabs" />', ['tabs' => $tabs]);

    $view->assertSee('5', false);
    $view->assertSee('rounded-full', false);
    $view->assertSee('bg-primary/10', false);
});

it('test_wire_model_attribute_passthrough', function () {
    $tabs = [
        ['name' => 'geral', 'label' => 'Dados Gerais'],
        ['name' => 'financeiro', 'label' => 'Financeiro'],
    ];

    $view = $this->blade('<x-jetax-tabs :tabs="$tabs" wire-model="activeTab" />', ['tabs' => $tabs]);

    $view->assertSee('wire:model', false);
});
