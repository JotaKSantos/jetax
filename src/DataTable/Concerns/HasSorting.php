<?php

namespace Jetax\DesignSystem\DataTable\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Jetax\DesignSystem\DataTable\Columns\Column;
use Livewire\Attributes\Url;

trait HasSorting
{
    #[Url(as: 'sortBy')]
    public ?string $sortBy = null;

    #[Url(as: 'sortDirection')]
    public string $sortDirection = 'asc';

    public function toggleSort(string $key): void
    {
        $column = collect($this->columns())
            ->first(fn (Column $column) => $column->getKey() === $key);

        if (! $column || ! $column->isSortable()) {
            return;
        }

        if ($this->sortBy === $key) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $key;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    protected function applySorting(Builder $builder): Builder
    {
        if ($this->sortBy === null) {
            return $builder;
        }

        $column = collect($this->columns())
            ->first(fn (Column $column) => $column->getKey() === $this->sortBy);

        if (! $column || ! $column->isSortable()) {
            return $builder;
        }

        $direction = strtolower($this->sortDirection) === 'desc' ? 'desc' : 'asc';

        return $builder->orderBy($this->sortBy, $direction);
    }
}
