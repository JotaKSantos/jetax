<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TagInput extends Component
{
    /**
     * Cria uma nova instância do campo de entrada de tags.
     *
     * Era `<x-jetax-tag>` até a v1.x; o nome novo separa o campo de entrada do chip de
     * exibição (`<x-jetax-chip>`).
     */
    public function __construct(
        /** @var array<int, string> */
        public array $suggestions = [],
        public ?int $max = null,
        public bool $disabled = false,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.tag-input');
    }
}
