<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TimelineItem extends Component
{
    /**
     * Mapeamento de cores para classes Tailwind do marcador.
     */
    protected const COLOR_MAP = [
        'primary' => ['bg' => 'bg-primary/12', 'dot' => 'bg-primary', 'text' => 'text-primary'],
        'success' => ['bg' => 'bg-success/12', 'dot' => 'bg-success', 'text' => 'text-success-text'],
        'warning' => ['bg' => 'bg-warning/12', 'dot' => 'bg-warning', 'text' => 'text-warning'],
        'danger' => ['bg' => 'bg-error/12', 'dot' => 'bg-error', 'text' => 'text-error'],
        'info' => ['bg' => 'bg-info/12', 'dot' => 'bg-info', 'text' => 'text-info'],
        'secondary' => ['bg' => 'bg-surface-container-high', 'dot' => 'bg-neutral-solid', 'text' => 'text-on-surface-variant'],
    ];

    /**
     * Cria uma nova instância do componente de item de timeline.
     */
    public function __construct(
        public string $title = '',
        public string $description = '',
        public string $date = '',
        public string $color = 'primary',
        public string $icon = '',
    ) {}

    /**
     * Retorna a classe CSS de fundo do marcador circular.
     */
    public function markerBgClass(): string
    {
        return self::COLOR_MAP[$this->color]['bg'] ?? self::COLOR_MAP['primary']['bg'];
    }

    /**
     * Retorna a classe CSS do ponto interno do marcador.
     */
    public function markerDotClass(): string
    {
        return self::COLOR_MAP[$this->color]['dot'] ?? self::COLOR_MAP['primary']['dot'];
    }

    /**
     * Retorna a classe CSS de cor do ícone.
     */
    public function iconColorClass(): string
    {
        return self::COLOR_MAP[$this->color]['text'] ?? self::COLOR_MAP['primary']['text'];
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.timeline-item');
    }
}
