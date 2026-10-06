<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Color extends Component
{
    /**
     * Cria uma nova instância do componente de seleção de cor.
     */
    public function __construct(
        public string $defaultColor = '#000000',
        public bool $disabled = false,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.color');
    }
}
