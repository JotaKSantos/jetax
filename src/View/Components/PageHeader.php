<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class PageHeader extends Component
{
    /**
     * Cria uma nova instância do componente PageHeader.
     *
     * @param  string  $title  Título da página (Manrope 700 20px)
     * @param  string|null  $subtitle  Subtítulo muted
     * @param  array<int, array{label: string, url?: string}>  $breadcrumbs  Itens de breadcrumb
     */
    public function __construct(
        public string $title = '',
        public ?string $subtitle = null,
        public array $breadcrumbs = [],
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.page-header');
    }
}
