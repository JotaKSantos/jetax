<?php

namespace Jetax\DesignSystem\DataTable\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;

trait HasPagination
{
    #[Url(as: 'per_page')]
    public ?int $perPage = null;

    public function resolvePerPage(): int
    {
        return $this->perPage
            ?? (int) config('jetax-data-table.per_page', 15);
    }

    protected function applyPagination(Builder $builder): LengthAwarePaginator
    {
        return $builder->paginate($this->resolvePerPage());
    }
}
