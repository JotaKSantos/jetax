<?php

namespace Jetax\DesignSystem\DataTable\Columns;

abstract class Column
{
    protected bool $sortable = false;

    protected bool $searchable = false;

    public function __construct(
        protected string $key,
        protected string $label,
    ) {}

    public static function make(string $key, ?string $label = null): static
    {
        return new static($key, $label ?? $key);
    }

    public function sortable(bool $sortable = true): static
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function searchable(bool $searchable = true): static
    {
        $this->searchable = $searchable;

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

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    /**
     * Renderiza o valor da célula para a linha informada.
     */
    abstract public function render(mixed $row): mixed;
}
