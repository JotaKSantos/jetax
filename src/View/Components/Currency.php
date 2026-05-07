<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Currency extends Component
{
    /**
     * Cria uma nova instância do componente de entrada de moeda.
     */
    public function __construct(
        public string $currency = 'R$',
        public string $locale = 'pt-BR',
        public int $precision = 2,
        public string $name = '',
        public bool $disabled = false,
    ) {}

    /**
     * Retorna as classes CSS do wrapper baseadas no estado atual.
     */
    public function wrapperClasses(): string
    {
        $base = 'flex items-center w-full rounded-lg border transition-all outline-none overflow-hidden';

        if ($this->disabled) {
            return $base.' bg-slate-100 border-slate-200 opacity-50 cursor-not-allowed';
        }

        return $base.' bg-[#f3f3ff] border-[#e2e6f1] focus-within:bg-white focus-within:border-[#0061a5] focus-within:shadow-[0_0_0_2px_rgba(0,97,165,0.1)]';
    }

    /**
     * Retorna as classes CSS do wrapper quando há erro.
     */
    public function errorWrapperClasses(): string
    {
        return 'flex items-center w-full rounded-lg border transition-all outline-none overflow-hidden bg-red-50 border-red-500 focus-within:border-red-500 focus-within:shadow-[0_0_0_2px_rgba(239,68,68,0.1)]';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.currency');
    }
}
