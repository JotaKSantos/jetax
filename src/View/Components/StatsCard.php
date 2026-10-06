<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

class StatsCard extends Component
{
    use ValidatesVariant;

    /**
     * Tendências disponíveis para o card.
     */
    public const TRENDS = ['up', 'down', 'neutral'];

    /**
     * Tons sólidos aceitos pela prop tone.
     */
    public const TONES = ['neutral', 'success', 'danger', 'warning', 'info'];

    /**
     * Arranjos aceitos pela prop layout: vazio (padrão) ou figure.
     */
    public const LAYOUTS = ['', 'figure'];

    /**
     * Fundo e borda sólidos de cada tom. O tom info usa primary-container,
     * porque a paleta não tem um info sólido com contraste para texto branco.
     */
    public const TONE_SURFACES = [
        'neutral' => 'bg-neutral-solid border-neutral-solid',
        'success' => 'bg-success-solid border-success-solid',
        'danger' => 'bg-danger-solid border-danger-solid',
        'warning' => 'bg-warning-solid border-warning-solid',
        'info' => 'bg-primary-container border-primary-container',
    ];

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
        public string $tone = '',
        public string $layout = '',
        public string $hint = '',
    ) {
        $this->layout = $this->validateVariant($layout, self::LAYOUTS, '', 'layout');

        if ($tone !== '') {
            $this->tone = $this->validateVariant($tone, self::TONES, 'neutral', 'tone');
        }

        if ($this->isFigure() && $this->tone === '') {
            $this->tone = 'neutral';
        }
    }

    /**
     * Indica se o card usa o arranjo figure.
     */
    public function isFigure(): bool
    {
        return $this->layout === 'figure';
    }

    /**
     * Indica se o card tem fundo sólido (gradiente ou tom), com texto claro.
     */
    public function isSolid(): bool
    {
        return $this->highlighted || $this->tone !== '';
    }

    /**
     * Retorna as classes de superfície do card: gradiente, tom sólido ou a
     * superfície neutra por token. Único ponto que decide o fundo.
     */
    public function surfaceClasses(): string
    {
        if ($this->highlighted) {
            return 'primary-gradient border-transparent text-on-primary shadow-lg';
        }

        if ($this->tone !== '') {
            return self::TONE_SURFACES[$this->tone].' text-on-primary shadow-sm';
        }

        return 'bg-surface-container-lowest border-outline-variant shadow-sm group hover:bg-surface-container-low transition-colors duration-300';
    }

    /**
     * Retorna as classes CSS do container principal do card.
     */
    public function cardClasses(): string
    {
        $arrangement = $this->isFigure()
            ? 'rounded-2xl border p-5 flex items-center gap-4'
            : 'rounded-2xl border p-6 flex flex-col gap-4';

        return $arrangement.' '.$this->surfaceClasses();
    }

    /**
     * Retorna as classes CSS do label conforme a superfície.
     */
    public function labelClasses(): string
    {
        return 'text-[11px] font-medium uppercase tracking-widest '
            .($this->isSolid() ? 'text-on-primary/75' : 'text-on-surface-variant');
    }

    /**
     * Retorna as classes CSS do valor conforme a superfície.
     */
    public function valueClasses(): string
    {
        return 'font-headline font-bold text-3xl '
            .($this->isSolid() ? 'text-on-primary' : 'text-on-surface');
    }

    /**
     * Retorna as classes CSS do container do ícone conforme a superfície.
     */
    public function iconContainerClasses(): string
    {
        if ($this->isFigure()) {
            return 'shrink-0 w-12 h-12 rounded-xl flex items-center justify-center bg-on-primary/20';
        }

        if ($this->isSolid()) {
            return 'p-2 rounded-full bg-on-primary/20';
        }

        return 'p-2 rounded-full bg-primary/10 group-hover:bg-primary/15 transition-colors';
    }

    /**
     * Retorna as classes CSS do ícone conforme a superfície.
     */
    public function iconClasses(): string
    {
        if ($this->isSolid()) {
            return 'material-symbols-outlined text-on-primary';
        }

        return 'material-symbols-outlined text-primary';
    }

    /**
     * Retorna as classes CSS do marcador de ajuda (hint) antes do rótulo.
     */
    public function hintClasses(): string
    {
        return 'inline-flex items-center justify-center w-4 h-4 rounded-full border text-[10px] font-bold leading-none cursor-help '
            .($this->isSolid() ? 'border-on-primary/60 text-on-primary/75' : 'border-outline text-on-surface-variant');
    }

    /**
     * Retorna as classes CSS do badge de trend baseado na direção.
     */
    public function trendClasses(): string
    {
        $base = 'flex items-center gap-1 px-2 py-1 rounded-lg text-sm font-bold ';

        if ($this->isSolid()) {
            return $base.'text-on-primary bg-on-primary/20';
        }

        return $base.match ($this->trend) {
            'up' => 'text-success-text bg-success/12',
            'down' => 'text-error bg-error/12',
            default => 'text-on-surface-variant bg-surface-container-high',
        };
    }

    /**
     * Retorna as classes CSS do ícone do trend.
     */
    public function trendIconClasses(): string
    {
        return 'material-symbols-outlined text-sm';
    }

    /**
     * Retorna o ícone Material Symbol para o trend.
     */
    public function trendIcon(): string
    {
        return match ($this->trend) {
            'up' => 'trending_up',
            'down' => 'trending_down',
            default => 'trending_flat',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.stats-card');
    }
}
