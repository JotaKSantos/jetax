<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Time extends Component
{
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
     * Retorna as classes CSS do input baseadas no estado atual.
     */
    public function inputClasses(): string
    {
        $base = 'w-full rounded-lg px-4 text-sm transition-all outline-none';

        return $base.' bg-[#f3f3ff] border border-[#e2e6f1] focus:bg-white focus:border-[#0061a5] focus:shadow-[0_0_0_2px_rgba(0,97,165,0.1)]';
    }

    /**
     * Retorna as classes CSS do input quando há erro.
     */
    public function errorClasses(): string
    {
        $base = 'w-full rounded-lg px-4 text-sm transition-all outline-none';

        return $base.' bg-red-50 border border-red-500 focus:border-red-500 focus:shadow-[0_0_0_2px_rgba(239,68,68,0.1)]';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.time');
    }
}
