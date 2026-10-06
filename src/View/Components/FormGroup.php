<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\FieldStyles;

class FormGroup extends Component
{
    use FieldStyles;

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
    public function render(): View
    {
        return view('jetax::components.form-group');
    }
}
