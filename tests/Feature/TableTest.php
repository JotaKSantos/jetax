<?php

use Illuminate\Pagination\LengthAwarePaginator;

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
    $view->assertSee('fa-arrows-up-down', false);
    $view->assertSee('fa-angle-up', false);
    $view->assertSee('fa-angle-down', false);
});

it('test_pagination_rendered_when_paginator_provided', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" :paginator="$paginator" />',
        [
            'columns' => [['key' => 'name', 'label' => 'Nome']],
            'rows' => [['name' => 'João Silva']],
            'paginator' => tablePaginator(),
        ]
    );

    $view->assertSee('aria-label="Paginação"', false);
});

/**
 * Paginador de 3 páginas para os testes de ordenação no servidor.
 */
function tablePaginator(): LengthAwarePaginator
{
    return (new LengthAwarePaginator(collect(range(1, 10)), 30, 10, 1))->withPath('/');
}

/**
 * Colunas e linhas de uma tabela de dinheiro, com `total` numérica.
 *
 * @return array{columns: array<int, array<string, mixed>>, rows: array<int, array<string, mixed>>}
 */
function moneyTable(): array
{
    return [
        'columns' => [
            ['key' => 'description', 'label' => 'Descrição', 'sortable' => true],
            ['key' => 'total', 'label' => 'Total', 'align' => 'right', 'sortable' => true, 'attributes' => ['data-col' => 'total']],
        ],
        'rows' => [
            ['description' => 'Consulta', 'total' => 'R$ 150,00'],
            ['description' => 'Vacina', 'total' => 'R$ 90,00'],
        ],
    ];
}

/**
 * Recorta o `<th>` que contém o atributo informado.
 */
function tableHeaderWith(string $html, string $needle): string
{
    preg_match('/<th\b[^>]*'.preg_quote($needle, '/').'[^>]*>/', $html, $match);

    return $match[0] ?? '';
}

it('test_column_align_and_attributes_on_header', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" />',
        moneyTable()
    );

    $th = tableHeaderWith((string) $view, 'data-col="total"');

    expect($th)->not->toBe('')
        ->and($th)->toContain('text-right')
        ->and($th)->not->toContain('text-left');
});

it('test_column_align_on_cells_in_client_mode', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" />',
        moneyTable()
    );

    expect((string) $view)->toMatch('/<td class="[^"]*text-right[^"]*" x-text="row\[\'total\'\]/');
});

it('test_column_align_on_cells_in_server_mode', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" :paginator="$paginator" />',
        [...moneyTable(), 'paginator' => tablePaginator()]
    );

    preg_match_all('/<td class="([^"]*)">\s*R\$ (?:150|90),00/', (string) $view, $cells);

    expect($cells[1])->toHaveCount(2);

    foreach ($cells[1] as $class) {
        expect($class)->toContain('text-right');
    }
});

it('test_column_width_class_and_th_class', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" />',
        [
            'columns' => [
                ['key' => 'qty', 'label' => 'Qtd', 'width' => '6rem', 'class' => 'tabular-nums', 'thClass' => 'whitespace-nowrap', 'attributes' => ['data-col' => 'qty']],
            ],
            'rows' => [['qty' => 3]],
        ]
    );

    $th = tableHeaderWith((string) $view, 'data-col="qty"');

    expect($th)->toContain('width: 6rem;')
        ->and($th)->toContain('whitespace-nowrap')
        ->and($th)->toContain('text-left');

    $view->assertSee('tabular-nums', false);
});

it('test_cell_slot_replaces_cell_text', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" :paginator="$paginator">
            <x-slot:cell-total><strong data-cell-rich x-text="row.total"></strong></x-slot:cell-total>
        </x-jetax-table>',
        [...moneyTable(), 'paginator' => tablePaginator()]
    );

    $html = (string) $view;

    expect(substr_count($html, 'data-cell-rich'))->toBe(2)
        ->and($html)->not->toContain('R$ 150,00</td>')
        ->and($html)->toContain('Consulta');
    expect(preg_match('/x-data="\{ row: /', $html))->toBe(1);
});

it('test_cell_slot_by_name_attribute_in_client_mode', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows">
            <x-slot name="cell-total"><em data-cell-rich x-text="row.total"></em></x-slot>
        </x-jetax-table>',
        moneyTable()
    );

    $html = (string) $view;

    expect(substr_count($html, 'data-cell-rich'))->toBe(1)
        ->and($html)->not->toContain('x-text="row[\'total\']');
});

it('test_without_cell_slot_rows_have_no_alpine_scope', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" :paginator="$paginator" />',
        [...moneyTable(), 'paginator' => tablePaginator()]
    );

    expect((string) $view)->not->toContain('x-data="{ row: ');
});

it('test_with_paginator_sort_only_dispatches_event', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" :paginator="$paginator" />',
        [...moneyTable(), 'paginator' => tablePaginator()]
    );

    $html = (string) $view;

    expect($html)->not->toContain('.sort(')
        ->and($html)->not->toContain('x-for=')
        ->and($html)->toContain("\$dispatch('sort', { key: key, direction: this.sortDirection })")
        ->and($html)->toContain("sortBy('total')");
});

it('test_without_paginator_sort_event_payload_uses_key', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" />',
        moneyTable()
    );

    $html = (string) $view;

    expect($html)->toContain('.sort(')
        ->and($html)->toContain("\$dispatch('sort', { key: column, direction: this.sortDirection })");
});

it('test_body_slot_with_paginator_keeps_server_sort_header', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="[]" :paginator="$paginator">
            <x-slot:body><tr><td>linha</td></tr></x-slot:body>
        </x-jetax-table>',
        ['columns' => moneyTable()['columns'], 'paginator' => tablePaginator()]
    );

    $html = (string) $view;

    expect($html)->toContain("sortBy('total')")
        ->and($html)->not->toContain('.sort(')
        ->and(tableHeaderWith($html, 'data-col="total"'))->toContain('text-right');
});

it('test_table_has_no_hex_literals', function () {
    $view = $this->blade(
        '<x-jetax-table :columns="$columns" :rows="$rows" :paginator="$paginator" selectable />',
        [...moneyTable(), 'paginator' => tablePaginator()]
    );

    expect((string) $view)->not->toContain('text-[#')
        ->and((string) $view)->not->toContain('bg-[#');
});
