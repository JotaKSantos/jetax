<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Estilos de botão disponíveis.
     */
    public const STYLES = ['solid', 'rounded', 'outline', 'outline-rounded', 'soft', 'soft-rounded'];

    /**
     * Cores disponíveis.
     */
    public const COLORS = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark', 'light'];

    /**
     * Tamanhos disponíveis.
     */
    public const SIZES = ['sm', 'md', 'lg'];

    /**
     * Cria uma nova instância do componente de botão.
     */
    public function __construct(
        public string $style = 'solid',
        public string $color = 'primary',
        public string $size = 'md',
        public bool $block = false,
        public bool $loading = false,
        public string $icon = '',
        public string $iconPosition = 'left',
    ) {}

    /**
     * Retorna as classes de tamanho para o botão.
     */
    public function sizeClasses(): string
    {
        $isRounded = in_array($this->style, ['rounded', 'outline-rounded', 'soft-rounded']);

        return match ($this->size) {
            'sm' => $isRounded ? 'px-3 py-1.5 text-xs' : 'px-3 py-1.5 text-xs rounded-lg',
            'lg' => $isRounded ? 'px-8 py-4 text-lg font-headline' : 'px-8 py-4 text-lg rounded-xl font-headline',
            default => $isRounded ? 'px-5 py-2.5 text-sm' : 'px-5 py-2.5 text-sm rounded-xl',
        };
    }

    /**
     * Mapa de classes por cor — todas as classes são literais para que o
     * Tailwind v4 as detecte durante o scan dos arquivos fonte.
     */
    private const COLOR_CLASSES = [
        'primary' => [
            'solid'           => 'bg-primary text-white hover:opacity-90',
            'rounded'         => 'bg-primary text-white rounded-full hover:opacity-90',
            'outline'         => 'border-2 border-primary text-primary bg-transparent hover:bg-primary/5',
            'outline-rounded' => 'border-2 border-primary text-primary bg-transparent rounded-full hover:bg-primary/5',
            'soft'            => 'bg-primary/10 text-primary hover:bg-primary/20',
            'soft-rounded'    => 'bg-primary/10 text-primary rounded-full hover:bg-primary/20',
        ],
        'secondary' => [
            'solid'           => 'bg-secondary text-white hover:opacity-90',
            'rounded'         => 'bg-secondary text-white rounded-full hover:opacity-90',
            'outline'         => 'border-2 border-secondary text-secondary bg-transparent hover:bg-secondary/5',
            'outline-rounded' => 'border-2 border-secondary text-secondary bg-transparent rounded-full hover:bg-secondary/5',
            'soft'            => 'bg-secondary/10 text-secondary hover:bg-secondary/20',
            'soft-rounded'    => 'bg-secondary/10 text-secondary rounded-full hover:bg-secondary/20',
        ],
        'success' => [
            'solid'           => 'bg-success text-white hover:opacity-90',
            'rounded'         => 'bg-success text-white rounded-full hover:opacity-90',
            'outline'         => 'border-2 border-success text-success bg-transparent hover:bg-success/5',
            'outline-rounded' => 'border-2 border-success text-success bg-transparent rounded-full hover:bg-success/5',
            'soft'            => 'bg-success/10 text-success hover:bg-success/20',
            'soft-rounded'    => 'bg-success/10 text-success rounded-full hover:bg-success/20',
        ],
        'info' => [
            'solid'           => 'bg-info text-white hover:opacity-90',
            'rounded'         => 'bg-info text-white rounded-full hover:opacity-90',
            'outline'         => 'border-2 border-info text-info bg-transparent hover:bg-info/5',
            'outline-rounded' => 'border-2 border-info text-info bg-transparent rounded-full hover:bg-info/5',
            'soft'            => 'bg-info/10 text-info hover:bg-info/20',
            'soft-rounded'    => 'bg-info/10 text-info rounded-full hover:bg-info/20',
        ],
        'warning' => [
            'solid'           => 'bg-warning text-white hover:opacity-90',
            'rounded'         => 'bg-warning text-white rounded-full hover:opacity-90',
            'outline'         => 'border-2 border-warning text-warning bg-transparent hover:bg-warning/5',
            'outline-rounded' => 'border-2 border-warning text-warning bg-transparent rounded-full hover:bg-warning/5',
            'soft'            => 'bg-warning/10 text-warning hover:bg-warning/20',
            'soft-rounded'    => 'bg-warning/10 text-warning rounded-full hover:bg-warning/20',
        ],
        'danger' => [
            'solid'           => 'bg-error text-white hover:opacity-90',
            'rounded'         => 'bg-error text-white rounded-full hover:opacity-90',
            'outline'         => 'border-2 border-error text-error bg-transparent hover:bg-error/5',
            'outline-rounded' => 'border-2 border-error text-error bg-transparent rounded-full hover:bg-error/5',
            'soft'            => 'bg-error/10 text-error hover:bg-error/20',
            'soft-rounded'    => 'bg-error/10 text-error rounded-full hover:bg-error/20',
        ],
        'dark' => [
            'solid'           => 'bg-on-surface text-white hover:opacity-90',
            'rounded'         => 'bg-on-surface text-white rounded-full hover:opacity-90',
            'outline'         => 'border-2 border-on-surface text-on-surface bg-transparent hover:bg-on-surface/5',
            'outline-rounded' => 'border-2 border-on-surface text-on-surface bg-transparent rounded-full hover:bg-on-surface/5',
            'soft'            => 'bg-on-surface/10 text-on-surface hover:bg-on-surface/20',
            'soft-rounded'    => 'bg-on-surface/10 text-on-surface rounded-full hover:bg-on-surface/20',
        ],
        'light' => [
            'solid'           => 'bg-surface-container-high text-on-surface rounded-xl hover:bg-surface-container-highest',
            'rounded'         => 'bg-surface-container-high text-on-surface rounded-full hover:bg-surface-container-highest',
            'outline'         => 'border-2 border-outline-variant text-on-surface-variant bg-transparent rounded-xl hover:bg-surface-container-low',
            'outline-rounded' => 'border-2 border-outline-variant text-on-surface-variant bg-transparent rounded-full hover:bg-surface-container-low',
            'soft'            => 'bg-surface-container-high text-on-surface rounded-xl hover:bg-surface-container-highest',
            'soft-rounded'    => 'bg-surface-container-high text-on-surface rounded-full hover:bg-surface-container-highest',
        ],
    ];

    /**
     * Retorna as classes de estilo e cor para o botão no estado normal.
     */
    public function styleClasses(): string
    {
        $color = $this->color;
        $style = $this->style;

        return self::COLOR_CLASSES[$color][$style]
            ?? self::COLOR_CLASSES[$color]['solid']
            ?? self::COLOR_CLASSES['primary'][$style]
            ?? self::COLOR_CLASSES['primary']['solid'];
    }

    /**
     * Retorna as classes de estado desabilitado para o botão.
     */
    public function disabledClasses(): string
    {
        return match (true) {
            in_array($this->style, ['outline', 'outline-rounded']) => 'border-2 border-outline-variant/30 text-outline-variant/50 bg-transparent cursor-not-allowed',
            in_array($this->style, ['soft', 'soft-rounded']) => 'bg-surface-container-low text-outline-variant/50 cursor-not-allowed',
            default => 'bg-primary/40 text-white/70 cursor-not-allowed',
        };
    }

    /**
     * Indica se o botão está desabilitado (loading ou atributo disabled).
     */
    public function isDisabled(): bool
    {
        return $this->loading;
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.button');
    }
}
