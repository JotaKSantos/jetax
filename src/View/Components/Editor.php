<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Editor extends Component
{
    /**
     * Cria uma nova instância do componente de editor rich text.
     */
    public function __construct(
        public string $placeholder = '',
        public string $height = '200px',
        public bool $disabled = false,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.editor');
    }
}
