<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class DocsLayout extends Component
{
    /**
     * Cria uma nova instância do componente de layout de documentação.
     */
    public function __construct(
        public string $title = 'Jetax — Design System',
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.docs-layout');
    }
}
