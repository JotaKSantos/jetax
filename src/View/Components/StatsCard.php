<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class StatsCard extends Component
{
    /**
     * Tendências disponíveis para o card.
     */
    public const TRENDS = ['up', 'down', 'neutral'];

    /**
     * Cria uma nova instância do componente stats card.
     */
    public function __construct(
        public string $label = '',
        public string $value = '',
        public string $trend = 'neutral',
        public string $trendValue = '',
        public string $icon = '',
        public bool $highlighted = false,
    ) {}

    /**
     * Retorna as classes CSS do container principal do card.
     */
    public function cardClasses(): string
    {
        if ($this->highlighted) {
            return 'primary-gradient text-white rounded-2xl shadow-lg p-6 flex flex-col gap-4';
        }

        return 'bg-white rounded-2xl shadow-sm p-6 flex flex-col gap-4 group hover:bg-surface-container-low transition-colors duration-300';
    }

    /**
     * Retorna as classes CSS do label baseado na variante highlighted.
     */
    public function labelClasses(): string
    {
        if ($this->highlighted) {
            return 'text-[11px] font-medium uppercase tracking-widest text-white/70';
        }

        return 'text-[11px] font-medium uppercase tracking-widest text-slate-400';
    }

    /**
     * Retorna as classes CSS do valor baseado na variante highlighted.
     */
    public function valueClasses(): string
    {
        if ($this->highlighted) {
            return 'font-headline font-bold text-3xl text-white';
        }

        return 'font-headline font-bold text-3xl text-on-surface';
    }

    /**
     * Retorna as classes CSS do container do ícone baseado na variante highlighted.
     */
    public function iconContainerClasses(): string
    {
        if ($this->highlighted) {
            return 'p-2 bg-white/20 rounded-full';
        }

        return 'p-2 bg-primary/5 rounded-full group-hover:bg-primary/10 transition-colors';
    }

    /**
     * Retorna as classes CSS do ícone baseado na variante highlighted.
     */
    public function iconClasses(): string
    {
        if ($this->highlighted) {
            return 'material-symbols-outlined text-white';
        }

        return 'material-symbols-outlined text-primary';
    }

    /**
     * Retorna as classes CSS do badge de trend baseado na direção.
     */
    public function trendClasses(): string
    {
        return match ($this->trend) {
            'up'   => 'flex items-center gap-1 text-green-600 bg-green-50 px-2 py-1 rounded-lg text-sm font-bold',
            'down' => 'flex items-center gap-1 text-error bg-red-50 px-2 py-1 rounded-lg text-sm font-bold',
            default => 'flex items-center gap-1 text-slate-500 bg-slate-50 px-2 py-1 rounded-lg text-sm font-bold',
        };
    }

    /**
     * Retorna o ícone Material Symbol para o trend.
     */
    public function trendIcon(): string
    {
        return match ($this->trend) {
            'up'    => 'trending_up',
            'down'  => 'trending_down',
            default => 'trending_flat',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.stats-card');
    }
}
