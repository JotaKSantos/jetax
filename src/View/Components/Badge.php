<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    /**
     * Variantes semânticas disponíveis.
     */
    public const VARIANTS = ['success', 'danger', 'warning', 'info', 'neutral'];

    /**
     * Estilos disponíveis.
     */
    public const STYLES = ['soft', 'solid', 'status'];

    /**
     * Tamanhos disponíveis.
     */
    public const SIZES = ['sm', 'md'];

    /**
     * Cria uma nova instância do componente de badge.
     */
    public function __construct(
        public string $variant = 'neutral',
        public string $style = 'soft',
        public bool $square = false,
        public string $size = 'md',
    ) {}

    /**
     * Retorna as classes de borda arredondada do badge.
     */
    public function radiusClasses(): string
    {
        return $this->square ? 'rounded-lg' : 'rounded-full';
    }

    /**
     * Retorna as classes de padding do badge.
     */
    public function paddingClasses(): string
    {
        if ($this->style === 'status') {
            return 'px-3 py-1.5';
        }

        return match ($this->size) {
            'sm' => 'px-2 py-0.5',
            default => 'px-3 py-1',
        };
    }

    /**
     * Retorna as classes de cor e fundo para o estilo soft.
     */
    protected function softClasses(): string
    {
        return match ($this->variant) {
            'success' => 'bg-green-500/10 text-green-700',
            'danger' => 'bg-error/10 text-error',
            'warning' => 'bg-amber-500/10 text-amber-700',
            'info' => 'bg-cyan-500/10 text-cyan-700',
            default => 'bg-slate-100 text-slate-600',
        };
    }

    /**
     * Retorna as classes de cor e fundo para o estilo solid.
     */
    protected function solidClasses(): string
    {
        return match ($this->variant) {
            'success' => 'bg-green-600 text-white',
            'danger' => 'bg-error text-white',
            'warning' => 'bg-amber-500 text-white',
            'info' => 'bg-cyan-600 text-white',
            default => 'bg-[#141A30] text-white',
        };
    }

    /**
     * Retorna as classes de cor e fundo para o estilo status.
     */
    protected function statusClasses(): string
    {
        return match ($this->variant) {
            'success' => 'bg-green-50 border border-green-100 text-green-700',
            'danger' => 'bg-error/5 border border-error/10 text-error',
            'warning' => 'bg-amber-50 border border-amber-100 text-amber-700',
            'info' => 'bg-blue-50 border border-blue-100 text-blue-700',
            default => 'bg-slate-50 border border-slate-200 text-slate-600',
        };
    }

    /**
     * Retorna as classes de cor do dot indicador para o estilo status.
     */
    public function dotClasses(): string
    {
        return match ($this->variant) {
            'success' => 'bg-green-500',
            'danger' => 'bg-error',
            'warning' => 'bg-amber-500',
            'info' => 'bg-blue-500',
            default => 'bg-slate-400',
        };
    }

    /**
     * Retorna as classes de cor e fundo baseadas no estilo atual.
     */
    public function colorClasses(): string
    {
        return match ($this->style) {
            'solid' => $this->solidClasses(),
            'status' => $this->statusClasses(),
            default => $this->softClasses(),
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.badge');
    }
}
