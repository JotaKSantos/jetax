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
    ) {}

    /**
     * Retorna as classes CSS da borda superior para variante featured.
     */
    public function containerClasses(): string
    {
        $base = 'rounded-xl overflow-hidden bg-white dark:bg-[rgb(22,27,42)]';

        if ($this->featured) {
            return $base.' shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] dark:shadow-[0_4px_20px_-2px_rgba(0,0,0,0.3)] border-t-4 border-error';
        }

        if ($this->bordered) {
            return $base.' shadow-sm border border-[rgb(193_199_210_/_0.1)] dark:border-white/5';
        }

        return $base.' shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)] dark:shadow-[0_4px_20px_-2px_rgba(0,0,0,0.3)]';
    }

    /**
     * Retorna as classes CSS do header baseado na variante.
     */
    public function headerClasses(): string
    {
        if ($this->featured) {
            return 'px-6 py-4 bg-error/5 dark:bg-error/10';
        }

        return 'px-6 py-4 bg-[#00497e]/[0.05] dark:bg-white/[0.03]';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.card');
    }
}
