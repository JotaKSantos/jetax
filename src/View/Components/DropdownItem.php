<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class DropdownItem extends Component
{
    /**
     * Cria uma nova instância do componente DropdownItem.
     */
    public function __construct(
        public ?string $href = null,
        public string $icon = '',
        public bool $destructive = false,
    ) {}

    /**
     * Retorna as classes de cor do item com base no estado destrutivo.
     */
    public function colorClasses(): string
    {
        if ($this->destructive) {
            return 'text-error hover:bg-error/5';
        }

        return 'text-on-surface hover:bg-primary/5';
    }

    /**
     * Indica se o item deve ser renderizado como link (<a>) ou botão (<button>).
     */
    public function isLink(): bool
    {
        return $this->href !== null;
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.dropdown-item');
    }
}
