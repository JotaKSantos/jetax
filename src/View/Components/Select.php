<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\FieldStyles;

class Select extends Component
{
    use FieldStyles;

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
     * A detecção de erro via $errors é feita no Blade template. A altura de
     * 40px vem da classe h-10 e o pr-9 reserva a faixa da seta.
     */
    public function selectClasses(bool $hasError = false): string
    {
        $base = 'w-full h-10 rounded-lg pl-4 pr-9 text-sm transition-all outline-none appearance-none';

        if ($this->disabled) {
            return $base.' bg-surface-container-low border border-outline-variant text-on-surface/40 cursor-not-allowed opacity-50';
        }

        if ($hasError) {
            return $base.' bg-error-container/30 border border-error text-on-surface focus:border-error focus:ring-2 focus:ring-error/20';
        }

        return $base.' bg-surface-input border border-outline-variant text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.select');
    }
}
