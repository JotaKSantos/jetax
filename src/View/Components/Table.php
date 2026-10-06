<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

class Table extends Component
{
    /**
     * Classes de alinhamento aceitas por coluna.
     *
     * @var array<string, string>
     */
    protected const ALIGN_CLASSES = [
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
    ];

    /**
     * Cria uma nova instância do componente de tabela.
     *
     * @param  array<int, array{key: string, label: string, sortable?: bool, align?: 'left'|'center'|'right', width?: string, class?: string, thClass?: string, attributes?: array<string, mixed>}>  $columns
     * @param  array<int, array<string, mixed>>  $rows
     */
    public function __construct(
        public array $columns = [],
        public array $rows = [],
        public bool $selectable = false,
        public ?LengthAwarePaginator $paginator = null,
    ) {}

    /**
     * Indica se a tabela não possui nenhuma linha.
     */
    public function isEmpty(): bool
    {
        return empty($this->rows);
    }

    /**
     * Indica se a tabela possui paginação.
     */
    public function hasPaginator(): bool
    {
        return $this->paginator !== null;
    }

    /**
     * Classe de alinhamento da coluna, aplicada no `<th>` e nas células.
     *
     * @param  array<string, mixed>  $column
     */
    public function alignClass(array $column): string
    {
        return self::ALIGN_CLASSES[$column['align'] ?? 'left'] ?? self::ALIGN_CLASSES['left'];
    }

    /**
     * Atributos do `<th>` da coluna: `attributes` do consumidor, largura e
     * classes (alinhamento, cabeçalho padrão e `thClass`).
     *
     * @param  array<string, mixed>  $column
     */
    public function headerAttributes(array $column): ComponentAttributeBag
    {
        $attributes = new ComponentAttributeBag($column['attributes'] ?? []);

        if (! empty($column['width'])) {
            $attributes = $attributes->merge(['style' => 'width: '.$column['width'].';']);
        }

        return $attributes->class([
            'px-6 py-3 text-xs font-medium uppercase tracking-wider text-on-surface-variant',
            $this->alignClass($column),
            $column['thClass'] ?? '',
        ]);
    }

    /**
     * Classes da célula da coluna: padrão, alinhamento e `class`.
     *
     * @param  array<string, mixed>  $column
     */
    public function cellClass(array $column): string
    {
        return trim(implode(' ', array_filter([
            'px-6 py-2.5 text-sm text-on-surface',
            $this->alignClass($column),
            $column['class'] ?? '',
        ])));
    }

    /**
     * Nomes aceitos para o slot de célula da coluna: `cell-<key>` (forma
     * `<x-slot name="cell-key">`) e `cellKey` (forma `<x-slot:cell-key>`,
     * que o Blade converte para camelCase).
     *
     * @param  array<string, mixed>  $column
     * @return array<int, string>
     */
    public function cellSlotNames(array $column): array
    {
        $name = 'cell-'.$column['key'];

        return array_values(array_unique([$name, Str::camel($name)]));
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.table');
    }
}
