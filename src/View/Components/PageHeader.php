<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageHeader extends Component
{
    /**
     * Cria uma nova instância do componente PageHeader.
     *
     * `icon`, `heading` e `subtitleBesideIcon` são props: não chegam ao HTML
     * como atributo.
     *
     * @param  string  $title  Título da página
     * @param  string|null  $subtitle  Subtítulo muted
     * @param  array<int, array{label: string, url?: string}>  $breadcrumbs  Itens de breadcrumb
     * @param  string|null  $icon  Material Symbol do quadrado de 44px à esquerda do título
     * @param  string  $heading  Tag do título: `h1` ou `h2` (padrão; qualquer outro valor vira `h2`)
     * @param  bool  $subtitleBesideIcon  Põe o subtítulo na coluna à direita do quadrado (só com `icon`)
     */
    public function __construct(
        public string $title = '',
        public ?string $subtitle = null,
        public array $breadcrumbs = [],
        public ?string $icon = null,
        public string $heading = 'h2',
        public bool $subtitleBesideIcon = false,
    ) {
        $this->heading = $heading === 'h1' ? 'h1' : 'h2';
        $this->subtitleBesideIcon = $subtitleBesideIcon && $this->hasIcon();
    }

    /**
     * Indica se o cabeçalho tem o quadrado de ícone.
     */
    public function hasIcon(): bool
    {
        return $this->icon !== null && $this->icon !== '';
    }

    /**
     * Classes do elemento de título: 26px/700 com ícone (desenho do cabeçalho
     * de tela); sem ícone, a tipografia original do pacote.
     */
    public function titleClasses(): string
    {
        if ($this->hasIcon()) {
            return 'font-headline text-on-surface tracking-tight text-[1.625rem] font-bold';
        }

        return 'text-[2.25rem] font-headline font-light text-on-surface tracking-tight';
    }

    /**
     * Classes do quadrado de ícone: 44px com gradiente `primary-container` →
     * `primary-deep`.
     */
    public function iconSquareClasses(): string
    {
        return 'w-11 h-11 flex-none rounded-[11px] bg-linear-to-br from-primary-container to-primary-deep flex items-center justify-center text-white';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.page-header');
    }
}
