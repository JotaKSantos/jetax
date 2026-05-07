<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * Cria uma nova instância do componente de layout principal.
     */
    public function __construct(
        public string $title = '',
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.layout');
    }
}
