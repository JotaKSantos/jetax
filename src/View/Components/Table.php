<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    /**
     * Cria uma nova instância do componente de tabela.
     *
     * @param  array<int, array{key: string, label: string, sortable?: bool}>  $columns
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
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.table');
    }
}
