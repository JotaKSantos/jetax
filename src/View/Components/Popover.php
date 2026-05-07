<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Popover extends Component
{
    /**
     * Posições disponíveis para o popover.
     */
    public const POSITIONS = ['top', 'bottom', 'left', 'right'];

    /**
     * Cria uma nova instância do componente de popover.
     */
    public function __construct(
        public string $position = 'bottom',
    ) {}

    /**
     * Retorna as classes CSS de posicionamento do popover.
     */
    public function popoverPositionClasses(): string
    {
        return match ($this->position) {
            'top'   => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
            'left'  => 'right-full top-1/2 -translate-y-1/2 mr-2',
            'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
            default => 'top-full left-1/2 -translate-x-1/2 mt-2',
        };
    }

    /**
     * Retorna as classes CSS da seta indicadora.
     */
    public function arrowClasses(): string
    {
        return match ($this->position) {
            'top'   => 'bottom-0 left-1/2 -translate-x-1/2 translate-y-full border-t-white border-l-transparent border-r-transparent border-b-transparent',
            'left'  => 'right-0 top-1/2 -translate-y-1/2 translate-x-full border-l-white border-t-transparent border-b-transparent border-r-transparent',
            'right' => 'left-0 top-1/2 -translate-y-1/2 -translate-x-full border-r-white border-t-transparent border-b-transparent border-l-transparent',
            default => 'top-0 left-1/2 -translate-x-1/2 -translate-y-full border-b-white border-l-transparent border-r-transparent border-t-transparent',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.popover');
    }
}
