<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Collapse extends Component
{
    /**
     * Cria uma nova instância do componente Collapse.
     *
     * @param  bool  $open  Estado inicial do conteúdo colapsável
     */
    public function __construct(
        public bool $open = false,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.collapse');
    }
}
