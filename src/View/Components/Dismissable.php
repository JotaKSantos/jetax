<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dismissable extends Component
{
    /**
     * Cria uma nova instância do componente Dismissable.
     */
    public function __construct(
        public ?string $persistKey = null,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.dismissable');
    }
}
