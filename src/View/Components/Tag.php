<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Tag extends Component
{
    /**
     * Cria uma nova instância do componente Tag.
     */
    public function __construct(
        public array $suggestions = [],
        public ?int $max = null,
        public bool $disabled = false,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.tag');
    }
}
