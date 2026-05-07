<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Spinner extends Component
{
    /**
     * Tamanhos disponíveis.
     */
    public const SIZES = ['sm', 'md', 'lg'];

    /**
     * Cria uma nova instância do componente de spinner.
     */
    public function __construct(
        public string $size = 'md',
        public string $color = '',
    ) {}

    /**
     * Retorna as classes de dimensão baseadas no tamanho configurado.
     */
    public function sizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'h-4 w-4 border-2',
            'lg' => 'h-12 w-12 border-[3px]',
            default => 'h-8 w-8 border-2',
        };
    }

    /**
     * Retorna as classes de cor da borda do spinner.
     * Quando color é vazio, usa currentColor herdado do contexto.
     */
    public function borderClasses(): string
    {
        return match ($this->color) {
            'primary'   => 'border-primary/20 border-t-primary',
            'secondary' => 'border-secondary/20 border-t-secondary',
            'success'   => 'border-success/20 border-t-success',
            'info'      => 'border-info/20 border-t-info',
            'warning'   => 'border-warning/20 border-t-warning',
            'danger'    => 'border-danger/20 border-t-danger',
            default     => 'border-current/20 border-t-current',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.spinner');
    }
}
