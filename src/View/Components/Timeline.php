<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Timeline extends Component
{
    /**
     * Cria uma nova instância do componente de timeline.
     */
    public function __construct(
        public bool $horizontal = false,
    ) {}

    /**
     * Retorna as classes CSS do container baseado no layout.
     */
    public function containerClasses(): string
    {
        if ($this->horizontal) {
            return 'flex flex-row items-start gap-0 overflow-x-auto';
        }

        return 'flex flex-col relative border-l border-slate-200 pl-6 space-y-6';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.timeline');
    }
}
