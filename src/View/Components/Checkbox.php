<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    /**
     * Identificador único gerado para associar o label ao input.
     */
    public string $checkboxId;

    /**
     * Cria uma nova instância do componente de checkbox.
     */
    public function __construct(
        public string $label = '',
        public bool $checked = false,
        public bool $disabled = false,
        public string $name = '',
    ) {
        $this->checkboxId = $name ? $name.'_'.uniqid() : 'checkbox_'.uniqid();
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.checkbox');
    }
}
