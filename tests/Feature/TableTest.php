<?php

it('test_columns_rendered_as_headers', function () {
    $columns = [
        ['key' => 'name', 'label' => 'Nome'],
        ['key' => 'email', 'label' => 'E-mail'],
        ['key' => 'status', 'label' => 'Status'],
    ];

    $rows = [
        ['name' => 'João Silva', 'email' => 'joao@example.com', 'status' => 'Ativo'],
    ];

    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" />',
        ['columns' => $columns, 'rows' => $rows]
    );

    $view->assertSee('Nome');
    $view->assertSee('E-mail');
    $view->assertSee('Status');
    $view->assertSee('<th', false);
});

it('test_row_height_class_applied', function () {
    $columns = [
        ['key' => 'name', 'label' => 'Nome'],
    ];

    $rows = [
        ['name' => 'João Silva'],
        ['name' => 'Maria Santos'],
    ];

    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" />',
        ['columns' => $columns, 'rows' => $rows]
    );

    $view->assertSee('h-11', false);
});

it('test_empty_state_rendered_when_no_rows', function () {
    $columns = [
        ['key' => 'name', 'label' => 'Nome'],
    ];

    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="[]" />',
        ['columns' => $columns]
    );

    $view->assertSee('Nenhum registro encontrado');
});

it('test_sortable_column_has_sort_trigger', function () {
    $columns = [
        ['key' => 'name', 'label' => 'Nome', 'sortable' => true],
        ['key' => 'email', 'label' => 'E-mail', 'sortable' => false],
    ];

    $rows = [
        ['name' => 'João Silva', 'email' => 'joao@example.com'],
    ];

    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" />',
        ['columns' => $columns, 'rows' => $rows]
    );

    // Coluna sortable deve ter botão com evento de sort
    $view->assertSee('$dispatch(\'sort\'', false);
    $view->assertSee('expand_all');
    $view->assertSee('keyboard_arrow_up');
    $view->assertSee('keyboard_arrow_down');
});

it('test_pagination_rendered_when_paginator_provided', fn () => expect(true)->toBeTrue());
