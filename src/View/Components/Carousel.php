<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Carousel extends Component
{
    /**
     * Cria uma nova instância do componente Carousel.
     *
     * @param  bool  $autoplay  Inicia a reprodução automática dos slides
     * @param  int  $interval  Intervalo em milissegundos entre os slides
     * @param  string  $transition  Tipo de transição: 'slide' ou 'fade'
     */
    public function __construct(
        public bool $autoplay = false,
        public int $interval = 5000,
        public string $transition = 'slide',
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.carousel');
    }
}
