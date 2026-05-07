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
        'primary'   => ['bg' => 'bg-blue-100', 'dot' => 'bg-blue-600', 'text' => 'text-blue-600'],
        'success'   => ['bg' => 'bg-emerald-100', 'dot' => 'bg-emerald-600', 'text' => 'text-emerald-600'],
        'warning'   => ['bg' => 'bg-amber-100', 'dot' => 'bg-amber-600', 'text' => 'text-amber-600'],
        'danger'    => ['bg' => 'bg-red-100', 'dot' => 'bg-red-600', 'text' => 'text-red-600'],
        'info'      => ['bg' => 'bg-sky-100', 'dot' => 'bg-sky-600', 'text' => 'text-sky-600'],
        'secondary' => ['bg' => 'bg-slate-100', 'dot' => 'bg-slate-500', 'text' => 'text-slate-500'],
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
