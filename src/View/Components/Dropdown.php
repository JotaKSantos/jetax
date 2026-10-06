<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

class Dropdown extends Component
{
    use ValidatesVariant;

    /**
     * Posicionamentos disponíveis para o menu dropdown.
     */
    public const POSITIONS = ['bottom-start', 'bottom-end', 'top-start', 'top-end'];

    /**
     * Cria uma nova instância do componente Dropdown.
     */
    public function __construct(
        public string $position = 'bottom-start',
    ) {
        $this->position = $this->validateVariant($position, self::POSITIONS, 'bottom-start', 'position');
    }

    /**
     * Direção vertical do menu em relação ao gatilho: `top` ou `bottom`.
     */
    public function vertical(): string
    {
        return str_starts_with($this->position, 'top') ? 'top' : 'bottom';
    }

    /**
     * Alinhamento horizontal do menu em relação ao gatilho: `start` ou `end`.
     */
    public function horizontal(): string
    {
        return str_ends_with($this->position, 'end') ? 'end' : 'start';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.dropdown');
    }
}
