<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    /**
     * Cria uma nova instância do componente Breadcrumbs.
     *
     * @param  array<int, array{label: string, url?: string}>  $items
     */
    public function __construct(
        public array $items = [],
    ) {}

    /**
     * Retorna os itens intermediários (todos exceto o último).
     *
     * @return array<int, array{label: string, url?: string}>
     */
    public function intermediaryItems(): array
    {
        if (count($this->items) <= 1) {
            return [];
        }

        return array_slice($this->items, 0, -1);
    }

    /**
     * Retorna o último item (atual), sem link.
     *
     * @return array{label: string, url?: string}|null
     */
    public function currentItem(): ?array
    {
        if (empty($this->items)) {
            return null;
        }

        return end($this->items) ?: null;
    }

    /**
     * Retorna os dois últimos itens para exibição mobile.
     *
     * @return array<int, array{label: string, url?: string}>
     */
    public function mobileItems(): array
    {
        return array_slice($this->items, -2);
    }

    /**
     * Indica se deve exibir truncamento (quando há mais de 2 itens).
     */
    public function shouldTruncate(): bool
    {
        return count($this->items) > 2;
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.breadcrumbs');
    }
}
