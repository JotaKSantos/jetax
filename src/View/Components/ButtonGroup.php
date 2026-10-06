<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ButtonGroup extends Component
{
    /**
     * Classes do grupo comum: os filhos ficam lado a lado e mantêm moldura e raio próprios.
     */
    public const GROUP_CLASSES = 'inline-flex items-stretch gap-2';

    /**
     * Classes do grupo dividido (`split`): uma moldura só para ação principal e gatilho.
     *
     * O raio e a divisória vêm de variantes descendentes (`[&>*]:`, `[&_button]:`), que vencem
     * em especificidade o raio que cada `<x-jetax-button>` declara para si; uma classe recebida
     * por `merge` no botão empataria e não zeraria nada. O `h-full` em `[&_button]` propaga a
     * altura do grupo ao botão do gatilho do dropdown, cujo wrapper já é `h-full`.
     */
    public const SPLIT_CLASSES = 'inline-flex items-stretch rounded-xl overflow-hidden'
        .' [&>*]:rounded-none [&_button]:rounded-none [&_button]:h-full'
        .' [&>*+*]:border-l [&>*+*]:border-outline-variant';

    /**
     * Cria uma nova instância do grupo de botões.
     */
    public function __construct(
        public bool $split = false,
    ) {}

    /**
     * Retorna as classes do contêiner conforme o modo do grupo.
     */
    public function containerClasses(): string
    {
        return $this->split ? self::SPLIT_CLASSES : self::GROUP_CLASSES;
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.button-group');
    }
}
