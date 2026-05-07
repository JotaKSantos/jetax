<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Tooltip extends Component
{
    /**
     * Posições disponíveis para o tooltip.
     */
    public const POSITIONS = ['top', 'bottom', 'left', 'right'];

    /**
     * Cria uma nova instância do componente de tooltip.
     */
    public function __construct(
        public string $content = '',
        public string $position = 'top',
    ) {}

    /**
     * Retorna as classes CSS de posicionamento do tooltip.
     */
    public function tooltipPositionClasses(): string
    {
        return match ($this->position) {
            'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
            'left'   => 'right-full top-1/2 -translate-y-1/2 mr-2',
            'right'  => 'left-full top-1/2 -translate-y-1/2 ml-2',
            default  => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
        };
    }

    /**
     * Retorna as classes CSS da seta indicadora.
     */
    public function arrowClasses(): string
    {
        return match ($this->position) {
            'bottom' => 'top-0 left-1/2 -translate-x-1/2 -translate-y-full border-b-slate-900 border-l-transparent border-r-transparent border-t-transparent',
            'left'   => 'right-0 top-1/2 -translate-y-1/2 translate-x-full border-l-slate-900 border-t-transparent border-b-transparent border-r-transparent',
            'right'  => 'left-0 top-1/2 -translate-y-1/2 -translate-x-full border-r-slate-900 border-t-transparent border-b-transparent border-l-transparent',
            default  => 'bottom-0 left-1/2 -translate-x-1/2 translate-y-full border-t-slate-900 border-l-transparent border-r-transparent border-b-transparent',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.tooltip');
    }
}
