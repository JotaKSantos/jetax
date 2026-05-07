<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Offcanvas extends Component
{
    /**
     * Posições disponíveis para o offcanvas.
     */
    public const POSITIONS = ['right', 'left', 'top', 'bottom'];

    /**
     * Cria uma nova instância do componente offcanvas.
     */
    public function __construct(
        public string $id = 'offcanvas',
        public string $position = 'right',
    ) {}

    /**
     * Retorna as classes CSS de posicionamento e dimensões do painel.
     */
    public function panelClasses(): string
    {
        return match ($this->position) {
            'left'   => 'absolute inset-y-0 left-0 w-full max-w-md bg-white shadow-2xl flex flex-col',
            'top'    => 'absolute inset-x-0 top-0 h-1/3 bg-white shadow-2xl flex flex-col',
            'bottom' => 'absolute inset-x-0 bottom-0 h-1/2 bg-white shadow-2xl flex flex-col',
            default  => 'absolute inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col',
        };
    }

    /**
     * Retorna as classes Alpine x-transition de entrada do painel.
     */
    public function enterStartClasses(): string
    {
        return match ($this->position) {
            'left'   => '-translate-x-full',
            'top'    => '-translate-y-full',
            'bottom' => 'translate-y-full',
            default  => 'translate-x-full',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.offcanvas');
    }
}
