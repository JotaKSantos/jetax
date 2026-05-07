<?php

namespace Jetax\DesignSystem\DataTable\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;

class DateFilter extends Filter
{
    public function hasValue(mixed $value): bool
    {
        if (! is_array($value)) {
            return false;
        }

        $from = $value['from'] ?? null;
        $to = $value['to'] ?? null;

        return ($from !== null && $from !== '') || ($to !== null && $to !== '');
    }

    public function apply(Builder $builder, mixed $value): Builder
    {
        if (! $this->hasValue($value)) {
            return $builder;
        }

        $from = $value['from'] ?? null;
        $to = $value['to'] ?? null;

        if ($from !== null && $from !== '' && $to !== null && $to !== '') {
            return $builder->whereBetween($this->key, [$from, $to]);
        }

        if ($from !== null && $from !== '') {
            return $builder->where($this->key, '>=', $from);
        }

        return $builder->where($this->key, '<=', $to);
    }

    public function getType(): string
    {
        return 'date';
    }
}
