<?php

namespace Jetax\DesignSystem\DataTable;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Jetax\DesignSystem\DataTable\Concerns\HasBulkActions;
use Jetax\DesignSystem\DataTable\Concerns\HasFilters;
use Jetax\DesignSystem\DataTable\Concerns\HasPagination;
use Jetax\DesignSystem\DataTable\Concerns\HasSearching;
use Jetax\DesignSystem\DataTable\Concerns\HasSorting;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

abstract class DataTableComponent extends Component
{
    use HasBulkActions;
    use HasFilters;
    use HasPagination;
    use HasSearching;
    use HasSorting;
    use WithPagination;

    /**
     * Fonte de dados: query Eloquent retornada pelo consumidor.
     */
    abstract public function builder(): Builder;

    /**
     * Colunas exibidas pela datatable.
     *
     * @return array<int, \Jetax\DesignSystem\DataTable\Columns\Column>
     */
    public function columns(): array
    {
        return [];
    }

    /**
     * Filtros disponíveis na toolbar.
     *
     * @return array<int, \Jetax\DesignSystem\DataTable\Filters\Filter>
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * Ações em lote disponíveis quando há seleção.
     *
     * @return array<int, \Jetax\DesignSystem\DataTable\BulkActions\BulkAction>
     */
    public function bulkActions(): array
    {
        return [];
    }

    /**
     * Chaves (strings) ou colunas marcadas como searchable.
     *
     * @return array<int, string>
     */
    public function searchableColumns(): array
    {
        return collect($this->columns())
            ->filter(fn ($column) => $column->isSearchable())
            ->map(fn ($column) => $column->getKey())
            ->values()
            ->all();
    }

    /**
     * Título exibido no empty state. Sobrescreva para customizar.
     */
    public function emptyTitle(): string
    {
        return 'Nenhum registro encontrado';
    }

    /**
     * Descrição exibida no empty state. Sobrescreva para customizar.
     */
    public function emptyDescription(): string
    {
        return '';
    }

    /**
     * Ícone exibido no empty state. Sobrescreva para customizar.
     */
    public function emptyIcon(): string
    {
        return 'inbox';
    }

    /**
     * Constrói a query final aplicando pipeline (sort, paginate).
     */
    #[Computed]
    public function rows(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $builder = $this->builder();
        $builder = $this->applySearching($builder);
        $builder = $this->applyFilters($builder);
        $builder = $this->applySorting($builder);

        return $this->applyPagination($builder);
    }

    public function render(): View
    {
        return view('jetax::components.data-table.index', [
            'columns' => $this->columns(),
            'filters' => $this->filters(),
            'bulkActions' => $this->bulkActions(),
            'rows' => $this->rows,
            'emptyTitle' => $this->emptyTitle(),
            'emptyDescription' => $this->emptyDescription(),
            'emptyIcon' => $this->emptyIcon(),
        ]);
    }
}
