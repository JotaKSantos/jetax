<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Progress extends Component
{
    /**
     * Cores disponíveis para o componente.
     */
    public const COLORS = ['primary', 'success', 'warning', 'danger'];

    /**
     * Cria uma nova instância do componente de progresso.
     */
    public function __construct(
        public int|float $value = 0,
        public int|float $max = 100,
        public string $color = 'primary',
        public string $size = 'md',
        public string|null $label = null,
        public bool $animated = false,
    ) {}

    /**
     * Retorna a classe de altura baseada no tamanho configurado.
     */
    public function sizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'h-1',
            'lg' => 'h-4',
            default => 'h-2',
        };
    }

    /**
     * Retorna o percentual de progresso limitado a 100%.
     */
    public function percentage(): float
    {
        if ($this->max <= 0) {
            return 0;
        }

        return min(100, ($this->value / $this->max) * 100);
    }

    /**
     * Retorna as classes de cor do fill da barra de progresso.
     */
    public function colorClasses(): string
    {
        return match ($this->color) {
            'success' => 'bg-emerald-500',
            'warning' => 'bg-amber-500',
            'danger' => 'bg-red-600',
            default => 'bg-[#0061a5]',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.progress');
    }
}
