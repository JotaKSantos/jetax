<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Currency extends Component
{
    /**
     * Identificador do campo visível, usado para associar o rótulo.
     *
     * Derivado do `name` quando existe: um `id` que muda a cada render faz o
     * morph do Livewire trocar o elemento no DOM e o cursor sair do campo.
     */
    public string $inputId;

    /**
     * Cria uma nova instância do componente de entrada de moeda.
     */
    public function __construct(
        public string $currency = 'R$',
        public string $locale = 'pt-BR',
        public int $precision = 2,
        public string $name = '',
        public bool $disabled = false,
        public string $label = '',
    ) {
        $this->inputId = $name !== ''
            ? 'currency_'.$name
            : 'currency_'.substr(md5($label.$currency), 0, 8);
    }

    /**
     * Retorna as classes CSS do wrapper baseadas no estado atual.
     */
    public function wrapperClasses(): string
    {
        $base = 'flex items-center w-full rounded-lg border transition-all outline-none overflow-hidden';

        if ($this->disabled) {
            return $base.' bg-surface-container-high border-outline-variant opacity-50 cursor-not-allowed';
        }

        return $base.' bg-surface-input border-outline-variant focus-within:bg-surface-container-lowest focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/10';
    }

    /**
     * Retorna as classes CSS do wrapper quando há erro.
     */
    public function errorWrapperClasses(): string
    {
        return 'flex items-center w-full rounded-lg border transition-all outline-none overflow-hidden bg-error-container/40 border-error focus-within:border-error focus-within:ring-2 focus-within:ring-error/10';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.currency');
    }
}
