<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Accordion extends Component
{
    /**
     * Cria uma nova instância do componente Accordion.
     *
     * @param  string  $mode  Modo de operação: 'single' (apenas um item aberto) ou 'multiple'
     */
    public function __construct(
        public string $mode = 'single',
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.accordion');
    }
}
