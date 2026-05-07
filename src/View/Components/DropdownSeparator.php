<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class DropdownSeparator extends Component
{
    /**
     * Cria uma nova instância do componente DropdownSeparator.
     */
    public function __construct() {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.dropdown-separator');
    }
}
