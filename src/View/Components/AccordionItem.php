<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class AccordionItem extends Component
{
    /**
     * Cria uma nova instância do componente AccordionItem.
     *
     * @param  string  $title  Título do item do accordion
     * @param  bool  $open  Estado inicial (aberto/fechado)
     */
    public function __construct(
        public string $title = '',
        public bool $open = false,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.accordion-item');
    }
}
