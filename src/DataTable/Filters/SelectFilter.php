<?php

namespace Jetax\DesignSystem\DataTable\Filters;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SelectFilter extends Filter
{
    /**
     * @var array<string|int, string>|Closure
     */
    protected array|Closure $options = [];

    /**
     * @param  array<string|int, string>|Closure  $options
     */
    public function options(array|Closure $options): static
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array<string|int, string>
     */
    public function getOptions(): array
    {
        if ($this->options instanceof Closure) {
            return ($this->options)();
        }

        return $this->options;
    }

    public function apply(Builder $builder, mixed $value): Builder
    {
        if (! $this->hasValue($value)) {
            return $builder;
        }

        return $builder->where($this->key, $value);
    }

    public function getType(): string
    {
        return 'select';
    }
}
