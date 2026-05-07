<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Dialog extends Component
{
    /**
     * Variantes disponíveis para o botão de confirmação.
     */
    public const VARIANTS = ['danger', 'warning', 'primary', 'success'];

    /**
     * Cria uma nova instância do componente de dialog.
     */
    public function __construct(
        public string $id = 'dialog',
        public string $title = '',
        public string $message = '',
        public string $confirmLabel = 'Confirmar',
        public string $cancelLabel = 'Cancelar',
        public string $variant = 'danger',
    ) {}

    /**
     * Retorna as classes CSS do botão de confirmação baseado na variante.
     */
    public function confirmButtonClasses(): string
    {
        $base = 'inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-150 hover:scale-[1.02] active:scale-95';

        return match ($this->variant) {
            'warning' => $base.' bg-amber-500 hover:bg-amber-600 text-white',
            'primary' => $base.' bg-primary hover:bg-primary/90 text-white',
            'success' => $base.' bg-green-600 hover:bg-green-700 text-white',
            default   => $base.' bg-red-600 hover:bg-red-700 text-white', // danger
        };
    }

    /**
     * Retorna o nome do ícone baseado na variante.
     */
    public function iconName(): string
    {
        return match ($this->variant) {
            'warning' => 'warning',
            'primary' => 'help',
            'success' => 'check_circle',
            default   => 'error', // danger
        };
    }

    /**
     * Retorna as classes CSS do ícone baseado na variante.
     */
    public function iconClasses(): string
    {
        return match ($this->variant) {
            'warning' => 'text-amber-500',
            'primary' => 'text-blue-500',
            'success' => 'text-green-500',
            default   => 'text-red-500', // danger
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.dialog');
    }
}
