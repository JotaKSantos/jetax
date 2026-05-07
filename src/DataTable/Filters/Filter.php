<?php

namespace Jetax\DesignSystem\DataTable\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;

abstract class Filter
{
    protected string $placeholder = '';

    public function __construct(
        protected string $key,
        protected string $label,
    ) {}

    public static function make(string $key, ?string $label = null): static
    {
        return new static($key, $label ?? $key);
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    /**
     * Indica se o valor informado deve disparar a aplicação do filtro.
     */
    public function hasValue(mixed $value): bool
    {
        if ($value === null || $value === '') {
            return false;
        }

        if (is_array($value)) {
            return collect($value)
                ->filter(fn ($item) => $item !== null && $item !== '')
                ->isNotEmpty();
        }

        return true;
    }

    /**
     * Aplica o filtro à query informada.
     */
    abstract public function apply(Builder $builder, mixed $value): Builder;

    /**
     * Identificador do tipo usado pela view do toolbar para escolher o input.
     */
    abstract public function getType(): string;
}
