<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

class Badge extends Component
{
    use ValidatesVariant;

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
     *
     * `color` é alias de `variant` e, quando informado, prevalece. Por ser
     * prop, não chega ao HTML como atributo.
     */
    public function __construct(
        public string $variant = 'neutral',
        public string $style = 'soft',
        public bool $square = false,
        public string $size = 'md',
        ?string $color = null,
    ) {
        $this->variant = $this->validateVariant($color ?? $variant, self::VARIANTS, 'neutral');
    }

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
            'success' => 'bg-success/10 text-success-text',
            'danger' => 'bg-error/10 text-error',
            'warning' => 'bg-warning/10 text-warning',
            'info' => 'bg-info/10 text-info',
            default => 'bg-surface-container-high text-on-surface-variant',
        };
    }

    /**
     * Retorna as classes de cor e fundo para o estilo solid.
     */
    protected function solidClasses(): string
    {
        return match ($this->variant) {
            'success' => 'bg-success-solid text-white',
            'danger' => 'bg-danger-solid text-white',
            'warning' => 'bg-warning-solid text-white',
            'info' => 'bg-secondary-container text-white',
            default => 'bg-neutral-solid text-white',
        };
    }

    /**
     * Retorna as classes de cor e fundo para o estilo status.
     */
    protected function statusClasses(): string
    {
        return match ($this->variant) {
            'success' => 'bg-success/10 border border-success/20 text-success-text',
            'danger' => 'bg-error/5 border border-error/10 text-error',
            'warning' => 'bg-warning/10 border border-warning/20 text-warning',
            'info' => 'bg-info/10 border border-info/20 text-info',
            default => 'bg-surface-container border border-outline-variant text-on-surface-variant',
        };
    }

    /**
     * Retorna as classes de cor do dot indicador para o estilo status.
     */
    public function dotClasses(): string
    {
        return match ($this->variant) {
            'success' => 'bg-success',
            'danger' => 'bg-error',
            'warning' => 'bg-warning',
            'info' => 'bg-info',
            default => 'bg-on-surface-variant',
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
