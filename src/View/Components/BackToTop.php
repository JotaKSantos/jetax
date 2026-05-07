<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BackToTop extends Component
{
    /**
     * Cria uma nova instância do componente Back to Top.
     */
    public function __construct(
        public int $threshold = 300,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.back-to-top');
    }
}
