<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StepItem extends Component
{
    /**
     * Cria uma nova instância do componente de item de etapa.
     */
    public function __construct(
        public string $label,
        public string $description = '',
        public int $step = 1,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.step-item');
    }
}
