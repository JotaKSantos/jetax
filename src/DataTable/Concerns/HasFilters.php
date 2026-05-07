<?php

namespace Jetax\DesignSystem\DataTable\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Jetax\DesignSystem\DataTable\Filters\Filter;
use Livewire\Attributes\Url;

trait HasFilters
{
    /**
     * @var array<string, mixed>
     */
    #[Url(as: 'f')]
    public array $filterValues = [];

    public function updatedFilterValues(): void
    {
        $this->resetPage();
    }

    protected function applyFilters(Builder $builder): Builder
    {
        $filters = collect($this->filters())
            ->keyBy(fn (Filter $filter) => $filter->getKey());

        foreach ($this->filterValues as $key => $value) {
            $filter = $filters->get($key);

            if (! $filter instanceof Filter) {
                continue;
            }

            $builder = $filter->apply($builder, $value);
        }

        return $builder;
    }
}
