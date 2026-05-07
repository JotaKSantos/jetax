<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListGroupItem extends Component
{
    /**
     * Cria uma nova instância do componente de item de list group.
     */
    public function __construct(
        public ?string $href = null,
        public string $icon = '',
        public string $title = '',
        public string $subtitle = '',
        public bool $active = false,
    ) {}

    /**
     * Indica se o item deve ser renderizado como link (<a>).
     */
    public function isLink(): bool
    {
        return $this->href !== null;
    }

    /**
     * Retorna as classes CSS do item baseadas no estado ativo e interativo.
     */
    public function itemClasses(): string
    {
        $base = 'px-6 py-4 flex items-center justify-between text-sm font-medium transition-colors group';

        if ($this->active) {
            return $base.' bg-primary/5 text-primary border-l-4 border-primary';
        }

        if ($this->isLink()) {
            return $base.' text-on-surface-variant hover:bg-surface-container-low';
        }

        return $base.' text-on-surface-variant';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.list-group-item');
    }
}
