<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Cria uma nova instância do componente de select.
     */
    public function __construct(
        public string $name = '',
        public string $label = '',
        public string $placeholder = '',
        public array $options = [],
        public bool $disabled = false,
    ) {}

    /**
     * Retorna as classes CSS do select baseadas no estado atual.
     * A detecção de erro via $errors é feita no Blade template.
     */
    public function selectClasses(bool $hasError = false): string
    {
        $base = 'w-full rounded-lg px-4 text-sm transition-all outline-none appearance-none';

        if ($this->disabled) {
            return $base.' bg-slate-100 border border-slate-200 text-slate-400 cursor-not-allowed opacity-50';
        }

        if ($hasError) {
            return $base.' bg-red-50 border border-red-500 focus:border-red-500 focus:shadow-[0_0_0_2px_rgba(239,68,68,0.1)]';
        }

        return $base.' bg-[#f3f3ff] border border-[#e2e6f1] focus:bg-white focus:border-[#0061a5] focus:shadow-[0_0_0_2px_rgba(0,97,165,0.1)]';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.select');
    }
}
