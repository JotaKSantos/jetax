<?php

it('test_labels_and_values_rendered', function () {
    $items = [
        ['label' => 'Cliente', 'value' => 'TechFlow Systems'],
        ['label' => 'CNPJ', 'value' => '45.290.112/0001-09'],
    ];

    $view = $this->blade('<x-jetax-detail-summary :items="$items" />', ['items' => $items]);

    $view->assertSee('Cliente');
    $view->assertSee('TechFlow Systems');
    $view->assertSee('CNPJ');
    $view->assertSee('45.290.112/0001-09');
});

it('test_columns_class_applied', function () {
    $items = [
        ['label' => 'Nome', 'value' => 'João'],
        ['label' => 'Email', 'value' => 'joao@email.com'],
    ];

    $view = $this->blade('<x-jetax-detail-summary :columns="2" :items="$items" />', ['items' => $items]);

    $view->assertSee('grid-cols-2', false);
});

it('test_label_has_muted_class', function () {
    $items = [
        ['label' => 'Status', 'value' => 'Ativo'],
    ];

    $view = $this->blade('<x-jetax-detail-summary :items="$items" />', ['items' => $items]);

    $view->assertSee('text-on-surface-variant', false);
});
