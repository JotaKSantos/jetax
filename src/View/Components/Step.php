<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Step extends Component
{
    /**
     * Cria uma nova instância do componente de wizard por etapas.
     */
    public function __construct(
        public int $current = 1,
        public bool $vertical = false,
        public bool $clickable = false,
    ) {}

    /**
     * Retorna as classes CSS do container baseado no layout.
     */
    public function containerClasses(): string
    {
        if ($this->vertical) {
            return 'step-vertical flex flex-col gap-0';
        }

        return 'step-horizontal flex flex-row items-start gap-0 w-full';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.step');
    }
}
