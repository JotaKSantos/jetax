<?php

namespace Jetax\DesignSystem\DataTable\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Jetax\DesignSystem\DataTable\BulkActions\BulkAction;

trait HasBulkActions
{
    /**
     * IDs dos registros selecionados. Persistem entre páginas da paginação.
     *
     * @var array<int, int|string>
     */
    public array $selectedIds = [];

    /**
     * Controla o checkbox "selecionar todos" do header (apenas página corrente).
     */
    public bool $selectAll = false;

    /**
     * Sincroniza `$selectedIds` com os IDs da página corrente quando
     * o usuário alterna o checkbox master do header.
     */
    public function updatedSelectAll(bool $value): void
    {
        $pageIds = $this->currentPageIds();

        if ($value) {
            $this->selectedIds = array_values(array_unique(array_merge($this->selectedIds, $pageIds)));

            return;
        }

        $this->selectedIds = array_values(array_diff($this->selectedIds, $pageIds));
    }

    /**
     * Limpa a seleção e desmarca o checkbox master.
     */
    public function clearSelection(): void
    {
        $this->selectedIds = [];
        $this->selectAll = false;
    }

    /**
     * Executa uma bulk action pelo seu `key` sobre os registros selecionados.
     */
    public function runBulkAction(string $key): mixed
    {
        $action = collect($this->bulkActions())
            ->first(fn (BulkAction $action) => $action->getKey() === $key);

        if (! $action instanceof BulkAction) {
            return null;
        }

        if (empty($this->selectedIds)) {
            return null;
        }

        $models = $this->resolveSelectedModels();

        $result = $action->handle($models);

        $this->clearSelection();

        return $result;
    }

    /**
     * Resolve os models Eloquent selecionados a partir de `$selectedIds`.
     */
    protected function resolveSelectedModels(): Collection
    {
        $builder = $this->builder();

        /** @var Collection $models */
        $models = $builder->getModel()
            ->newQuery()
            ->whereIn($builder->getModel()->getKeyName(), $this->selectedIds)
            ->get();

        return $models;
    }

    /**
     * Retorna os IDs da página corrente aplicando todos os filtros ativos.
     *
     * @return array<int, int|string>
     */
    protected function currentPageIds(): array
    {
        return collect($this->rows->items())
            ->map(fn ($row) => $row->getKey())
            ->values()
            ->all();
    }
}
