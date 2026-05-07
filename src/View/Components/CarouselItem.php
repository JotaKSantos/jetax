<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class CarouselItem extends Component
{
    /**
     * Cria uma nova instância do componente CarouselItem.
     */
    public function __construct() {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.carousel-item');
    }
}
