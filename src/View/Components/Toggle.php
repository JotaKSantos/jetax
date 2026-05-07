<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Toggle extends Component
{
    /**
     * Identificador único gerado para associar o label ao toggle.
     */
    public string $toggleId;

    /**
     * Cria uma nova instância do componente de toggle.
     */
    public function __construct(
        public string $label = '',
        public bool $disabled = false,
        public string $name = '',
        public bool $checked = false,
    ) {
        $this->toggleId = $name ? $name.'_'.uniqid() : 'toggle_'.uniqid();
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.toggle');
    }
}
