<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\FieldStyles;

class Time extends Component
{
    use FieldStyles;

    /**
     * Formatos de exibição disponíveis para o input de horário.
     */
    public const FORMAT_24H = 'HH:MM';

    public const FORMAT_12H = 'hh:MM AM/PM';

    /**
     * Cria uma nova instância do componente de horário.
     */
    public function __construct(
        public string $name = '',
        public string $label = '',
        public string $format = self::FORMAT_24H,
        public int $step = 60,
        public bool $disabled = false,
    ) {}

    /**
     * Retorna as classes CSS do input baseadas no estado atual. A altura de
     * 40px vem da classe h-10, nunca de style inline.
     */
    public function inputClasses(): string
    {
        $base = 'w-full h-10 rounded-lg px-4 text-sm transition-all outline-none';

        return $base.' bg-surface-input border border-outline-variant text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20';
    }

    /**
     * Retorna as classes CSS do input quando há erro.
     */
    public function errorClasses(): string
    {
        $base = 'w-full h-10 rounded-lg px-4 text-sm transition-all outline-none';

        return $base.' bg-error-container/30 border border-error text-on-surface focus:border-error focus:ring-2 focus:ring-error/20';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.time');
    }
}
