<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Range extends Component
{
    /**
     * Cria uma nova instância do componente de range.
     */
    public function __construct(
        public int|float $min = 0,
        public int|float $max = 100,
        public int|float $step = 1,
        public int|float $value = 50,
        public bool $showValue = false,
        public bool $disabled = false,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.range');
    }
}
