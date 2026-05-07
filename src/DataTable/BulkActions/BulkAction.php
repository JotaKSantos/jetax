<?php

namespace Jetax\DesignSystem\DataTable\BulkActions;

use Illuminate\Database\Eloquent\Collection;

class BulkAction
{
    /**
     * Callback executado quando a ação for disparada.
     *
     * @var (\Closure(Collection): mixed)|null
     */
    protected ?\Closure $handler = null;

    /**
     * Ícone opcional (Material Symbols) exibido ao lado do label.
     */
    protected ?string $icon = null;

    /**
     * Mensagem de confirmação exibida antes de executar (quando setada).
     */
    protected ?string $confirm = null;

    /**
     * Variante visual do botão (primary, danger, etc.).
     */
    protected string $variant = 'secondary';

    final public function __construct(
        protected string $key,
        protected string $label,
    ) {
    }

    public static function make(string $key, string $label): static
    {
        return new static($key, $label);
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function confirm(string $message): static
    {
        $this->confirm = $message;

        return $this;
    }

    public function variant(string $variant): static
    {
        $this->variant = $variant;

        return $this;
    }

    public function handler(\Closure $handler): static
    {
        $this->handler = $handler;

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getConfirm(): ?string
    {
        return $this->confirm;
    }

    public function getVariant(): string
    {
        return $this->variant;
    }

    /**
     * Executa a ação contra os models selecionados.
     */
    public function handle(Collection $models): mixed
    {
        if ($this->handler === null) {
            return null;
        }

        return ($this->handler)($models);
    }
}
