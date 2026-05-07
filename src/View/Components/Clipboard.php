<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Clipboard extends Component
{
    /**
     * Cria uma nova instância do componente de área de transferência.
     */
    public function __construct(
        public string $text,
        public string $successMessage = '',
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.clipboard');
    }
}
