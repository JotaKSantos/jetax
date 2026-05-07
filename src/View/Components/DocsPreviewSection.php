<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class DocsPreviewSection extends Component
{
    /**
     * Cria uma nova instância do componente de seção de preview da documentação.
     */
    public function __construct(
        public string $title,
        public string $code = '',
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.docs-preview-section');
    }
}
