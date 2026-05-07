<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class ToastContainer extends Component
{
    /**
     * Posições disponíveis para o container de toast.
     */
    public const POSITIONS = ['bottom-right', 'bottom-left', 'top-right', 'top-left'];

    /**
     * Cria uma nova instância do componente de toast container.
     */
    public function __construct(
        public string $position = 'bottom-right',
    ) {}

    /**
     * Retorna as classes CSS de posicionamento do container.
     */
    public function positionClasses(): string
    {
        return match ($this->position) {
            'bottom-left' => 'bottom-6 left-6',
            'top-right'   => 'top-6 right-6',
            'top-left'    => 'top-6 left-6',
            default       => 'bottom-6 right-6',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.toast-container');
    }
}
