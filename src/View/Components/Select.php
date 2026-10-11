<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\FieldStyles;
use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

class Select extends Component
{
    use FieldStyles;
    use ValidatesVariant;

    /**
     * Estados aceitos pela prop `state`, com o mesmo nome do `<x-jetax-input>` (JETAX-036).
     */
    public const STATES = ['error'];

    /**
     * Cria uma nova instância do componente de select.
     *
     * `state="error"` pinta o erro sem depender do `$errors` do `name` (JETAX-036).
     */
    public function __construct(
        public string $name = '',
        public string $label = '',
        public string $placeholder = '',
        public array $options = [],
        public bool $disabled = false,
        public string $state = '',
    ) {
        if ($state !== '') {
            $this->state = $this->validateVariant($state, self::STATES, '', 'state');
        }
    }

    /**
     * Retorna as classes CSS do select baseadas no estado atual.
     * A detecção de erro via $errors é feita no Blade template; `state="error"`
     * entra no mesmo ramo. A altura de 38px vem da classe h-[38px] e o pr-9
     * reserva a faixa da seta (JETAX-036).
     */
    public function selectClasses(bool $hasError = false): string
    {
        $base = 'w-full h-[38px] rounded-[8px] pl-2.5 pr-9 text-sm transition-all outline-none appearance-none';

        if ($this->disabled) {
            return $base.' bg-surface-container-low border border-outline-variant text-on-surface/40 cursor-not-allowed opacity-50';
        }

        if ($hasError || $this->state === 'error') {
            return $base.' bg-error-container/30 border border-error text-on-surface focus:border-error focus:ring-2 focus:ring-error/20';
        }

        return $base.' bg-surface-input border border-primary/18 text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.select');
    }
}
