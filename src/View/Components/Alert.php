<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Estilos disponíveis para o alerta.
     */
    public const STYLES = ['soft', 'solid', 'rich'];

    /**
     * Variantes de cor disponíveis.
     */
    public const VARIANTS = ['primary', 'info', 'success', 'warning', 'danger'];

    /**
     * Cria uma nova instância do componente de alerta.
     */
    public function __construct(
        public ?string $message = null,
        public string $variant = 'primary',
        public string $style = 'soft',
        public bool $dismissible = false,
        public ?string $title = null,
        public string $icon = '',
    ) {}

    /**
     * Retorna as classes CSS do container para o estilo solid.
     */
    public function solidClasses(): string
    {
        return match ($this->variant) {
            'info'    => 'bg-[#0397FD] text-white shadow-md',
            'success' => 'bg-[#2E7D32] text-white shadow-md',
            'warning' => 'bg-[#EF6C00] text-white shadow-md',
            'danger'  => 'bg-error text-white shadow-md',
            default   => 'bg-primary text-white shadow-md',
        };
    }

    /**
     * Retorna as classes CSS do container para o estilo soft.
     */
    public function softClasses(): string
    {
        return match ($this->variant) {
            'info'    => 'bg-[#0397FD]/10 text-[#0397FD] border border-[#0397FD]/20',
            'success' => 'bg-[#2E7D32]/10 text-[#2E7D32] border border-[#2E7D32]/20',
            'warning' => 'bg-[#EF6C00]/10 text-[#EF6C00] border border-[#EF6C00]/20',
            'danger'  => 'bg-error/10 text-error border border-error/20',
            default   => 'bg-primary/10 text-primary border border-primary/20',
        };
    }

    /**
     * Retorna as classes CSS da borda esquerda para o estilo rich.
     */
    public function richBorderClass(): string
    {
        return match ($this->variant) {
            'info'    => 'border-[#0397FD]',
            'success' => 'border-[#2E7D32]',
            'warning' => 'border-[#EF6C00]',
            'danger'  => 'border-error',
            default   => 'border-primary',
        };
    }

    /**
     * Retorna a classe de cor do texto/ícone para o estilo rich.
     */
    public function richTextClass(): string
    {
        return match ($this->variant) {
            'info'    => 'text-[#0397FD]',
            'success' => 'text-[#2E7D32]',
            'warning' => 'text-[#EF6C00]',
            'danger'  => 'text-error',
            default   => 'text-primary',
        };
    }

    /**
     * Retorna as classes CSS do container para o estilo rich.
     */
    public function richContainerClass(): string
    {
        return match ($this->variant) {
            'info'    => 'bg-[#0397FD]/5',
            'success' => 'bg-[#2E7D32]/5',
            'warning' => 'bg-[#EF6C00]/5',
            'danger'  => 'bg-error-container/20',
            default   => 'bg-primary/5',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.alert');
    }
}
