<?php

namespace Jetax\DesignSystem\DataTable\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;

class MultiSelectFilter extends SelectFilter
{
    public function apply(Builder $builder, mixed $value): Builder
    {
        if (! $this->hasValue($value)) {
            return $builder;
        }

        $values = collect((array) $value)
            ->filter(fn ($item) => $item !== null && $item !== '')
            ->values()
            ->all();

        if (empty($values)) {
            return $builder;
        }

        return $builder->whereIn($this->key, $values);
    }

    public function getType(): string
    {
        return 'multiselect';
    }
}
