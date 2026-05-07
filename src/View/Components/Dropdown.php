<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{
    /**
     * Posicionamentos disponíveis para o menu dropdown.
     */
    public const POSITIONS = ['bottom-start', 'bottom-end'];

    /**
     * Cria uma nova instância do componente Dropdown.
     */
    public function __construct(
        public string $position = 'bottom-start',
    ) {}

    /**
     * Retorna as classes de posicionamento do menu.
     */
    public function menuPositionClasses(): string
    {
        return match ($this->position) {
            'bottom-end' => 'right-0 left-auto',
            default => 'left-0',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.dropdown');
    }
}
