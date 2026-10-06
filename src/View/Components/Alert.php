<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

class Alert extends Component
{
    use ValidatesVariant;

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
    ) {
        $this->variant = $this->validateVariant($variant, self::VARIANTS, 'primary');
    }

    /**
     * Retorna as classes CSS do container para o estilo solid.
     */
    public function solidClasses(): string
    {
        return match ($this->variant) {
            'info' => 'bg-secondary-container text-white shadow-md',
            'success' => 'bg-success-solid text-white shadow-md',
            'warning' => 'bg-warning-solid text-white shadow-md',
            'danger' => 'bg-danger-solid text-white shadow-md',
            default => 'bg-primary text-white shadow-md',
        };
    }

    /**
     * Retorna as classes CSS do container para o estilo soft.
     */
    public function softClasses(): string
    {
        return match ($this->variant) {
            'info' => 'bg-info/10 text-info border border-info/20',
            'success' => 'bg-success/10 text-success-text border border-success/20',
            'warning' => 'bg-warning/10 text-warning border border-warning/20',
            'danger' => 'bg-error/10 text-error border border-error/20',
            default => 'bg-primary/10 text-primary border border-primary/20',
        };
    }

    /**
     * Retorna as classes CSS da borda esquerda para o estilo rich.
     */
    public function richBorderClass(): string
    {
        return match ($this->variant) {
            'info' => 'border-info',
            'success' => 'border-success',
            'warning' => 'border-warning',
            'danger' => 'border-error',
            default => 'border-primary',
        };
    }

    /**
     * Retorna a classe de cor do texto/ícone para o estilo rich.
     */
    public function richTextClass(): string
    {
        return match ($this->variant) {
            'info' => 'text-info',
            'success' => 'text-success-text',
            'warning' => 'text-warning',
            'danger' => 'text-error',
            default => 'text-primary',
        };
    }

    /**
     * Retorna as classes CSS do container para o estilo rich.
     */
    public function richContainerClass(): string
    {
        return match ($this->variant) {
            'info' => 'bg-info/5',
            'success' => 'bg-success/5',
            'warning' => 'bg-warning/5',
            'danger' => 'bg-error-container/20',
            default => 'bg-primary/5',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.alert');
    }
}
