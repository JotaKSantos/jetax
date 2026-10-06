<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component
{
    /**
     * Identificador que associa o label ao input. Derivado do name, para ser
     * estável entre renders (o morph do Livewire troca o elemento quando o
     * id muda). Sem name, o id é único por render, porque caixas sem name
     * costumam se repetir em lista e não podem colidir.
     */
    public string $checkboxId;

    /**
     * Cria uma nova instância do componente de checkbox.
     */
    public function __construct(
        public string $label = '',
        public bool $checked = false,
        public bool $disabled = false,
        public string $name = '',
    ) {
        $this->checkboxId = $name !== ''
            ? 'checkbox_'.$name
            : 'checkbox_'.uniqid();
    }

    /**
     * Classes da caixa: repouso, marcado e foco por token.
     */
    public function inputClasses(): string
    {
        return 'appearance-none w-4 h-4 rounded border border-outline-variant bg-surface-input cursor-pointer '
            ."checked:bg-primary checked:border-primary checked:bg-[url('data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%2016%2016%22%20fill%3D%22white%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M12.207%204.793a1%201%200%20010%201.414l-5%205a1%201%200%2001-1.414%200l-2-2a1%201%200%20011.414-1.414L6.5%209.086l4.293-4.293a1%201%200%20011.414%200z%22%2F%3E%3C%2Fsvg%3E')] "
            .'checked:bg-center checked:bg-no-repeat checked:bg-[length:14px_14px] '
            .'focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1 '
            .'disabled:opacity-50 disabled:cursor-not-allowed transition-colors';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.checkbox');
    }
}
