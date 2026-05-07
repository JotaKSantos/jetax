<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class FormGroup extends Component
{
    /**
     * Cria uma nova instância do componente de agrupamento de formulário.
     */
    public function __construct(
        public string $label = '',
        public string $name = '',
        public string $hint = '',
        public bool $required = false,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.form-group');
    }
}
