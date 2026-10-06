<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toggle extends Component
{
    /**
     * Identificador do toggle, usado para associar o label ao botão.
     *
     * Derivado do `name` quando existe: um `id` que muda a cada render faz o
     * morph do Livewire trocar o elemento no DOM e perder foco e transição.
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
        $this->toggleId = $name !== '' ? 'toggle_'.$name : 'toggle_'.uniqid();
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.toggle');
    }
}
