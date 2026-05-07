<?php

namespace Jetax\DesignSystem\DataTable\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Url;

trait HasSearching
{
    #[Url(as: 'q')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    protected function applySearching(Builder $builder): Builder
    {
        $term = trim($this->search);

        if ($term === '') {
            return $builder;
        }

        $columns = $this->searchableColumns();

        if (empty($columns)) {
            return $builder;
        }

        return $builder->where(function (Builder $query) use ($columns, $term) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', '%'.$term.'%');
            }
        });
    }
}
