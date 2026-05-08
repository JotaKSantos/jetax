<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Cria uma nova instância do componente de card.
     */
    public function __construct(
        public string $padding = '1.5rem',
        public bool $featured = false,
        public bool $bordered = false,
        public string $headerClass = '',
        public string $footerClass = '',
    ) {}

    /**
     * Retorna as classes CSS do container baseadas na variante.
     */
    public function containerClasses(): string
    {
        $base = 'rounded-xl overflow-hidden bg-white dark:bg-[#161B2A]';

        if ($this->featured) {
            return $base.' shadow-sm shadow-[#111A37]/5 dark:shadow-lg dark:shadow-black/20 dark:border dark:border-white/[0.05] border-t-4 border-error';
        }

        if ($this->bordered) {
            return $base.' shadow-sm border border-outline-variant dark:border-white/[0.05]';
        }

        return $base.' shadow-sm shadow-[#111A37]/5 dark:shadow-lg dark:shadow-black/20 dark:border dark:border-white/[0.05]';
    }

    /**
     * Retorna as classes CSS do header baseado na variante, mescladas com o
     * override do consumidor via prop headerClass.
     */
    public function headerClasses(): string
    {
        $typography = 'font-headline font-bold text-sm uppercase tracking-wide flex items-center gap-2';

        $base = $this->featured
            ? 'px-6 py-4 bg-error/5 dark:bg-error/10 border-b border-error/20 text-error '.$typography
            : 'px-6 py-4 bg-secondary/5 dark:bg-primary/5 border-b border-outline-variant/30 dark:border-white/[0.05] text-secondary dark:text-primary '.$typography;

        return trim($base.' '.$this->headerClass);
    }

    /**
     * Retorna as classes CSS do footer mescladas com o override do consumidor
     * via prop footerClass.
     */
    public function footerClasses(): string
    {
        return trim('bg-surface-container-low px-6 py-4 '.$this->footerClass);
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.card');
    }
}
