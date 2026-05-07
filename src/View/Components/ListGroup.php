<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListGroup extends Component
{
    /**
     * Cria uma nova instância do componente de list group.
     */
    public function __construct() {}

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.list-group');
    }
}
