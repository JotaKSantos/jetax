<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Radio extends Component
{
    /**
     * Identificador único gerado para associar o label ao input.
     */
    public string $radioId;

    /**
     * Cria uma nova instância do componente de radio button.
     */
    public function __construct(
        public string $label = '',
        public string $value = '',
        public string $name = '',
        public bool $disabled = false,
    ) {
        $this->radioId = $name ? $name.'_'.uniqid() : 'radio_'.uniqid();
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.radio');
    }
}
