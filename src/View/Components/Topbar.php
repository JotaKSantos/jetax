<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Topbar extends Component
{
    /**
     * Cria uma nova instância do componente Topbar.
     *
     * `sidebarWidth` e `collapsedWidth` são as larguras da sidebar expandida e
     * recolhida (valor CSS, ex.: `246px`), usadas no `md:left-[…]` da barra.
     * A classe é arbitrária: a aplicação que passar uma largura diferente do
     * padrão precisa que o Tailwind dela gere `md:left-[<valor>]` (por exemplo,
     * com `@source inline("md:left-[246px] md:left-[70px]")`).
     */
    public function __construct(
        public string $title = '',
        public string $sidebarWidth = '16rem',
        public string $collapsedWidth = '70px',
    ) {}

    /**
     * Classe de deslocamento com a sidebar expandida.
     */
    public function expandedLeftClass(): string
    {
        return 'md:left-['.$this->sidebarWidth.']';
    }

    /**
     * Classe de deslocamento com a sidebar recolhida.
     */
    public function collapsedLeftClass(): string
    {
        return 'md:left-['.$this->collapsedWidth.']';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.topbar');
    }
}
