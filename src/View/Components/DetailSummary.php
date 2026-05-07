<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DetailSummary extends Component
{
    /**
     * Número máximo de colunas suportadas.
     */
    public const MAX_COLUMNS = 3;

    /**
     * Cria uma nova instância do componente detail summary.
     *
     * @param  array<int, array{label: string, value: string}>  $items
     */
    public function __construct(
        public array $items = [],
        public int $columns = 1,
    ) {}

    /**
     * Retorna as classes CSS do grid baseado no número de colunas.
     */
    public function gridClasses(): string
    {
        return match ($this->columns) {
            2 => 'grid grid-cols-2 gap-x-6 gap-y-4',
            3 => 'grid grid-cols-3 gap-x-6 gap-y-4',
            default => 'grid grid-cols-1 gap-y-4',
        };
    }

    /**
     * Retorna as classes CSS do label de cada item.
     */
    public function labelClasses(): string
    {
        return 'text-xs font-medium uppercase tracking-wider text-on-surface-variant';
    }

    /**
     * Retorna as classes CSS do valor de cada item.
     */
    public function valueClasses(): string
    {
        return 'text-sm text-on-surface';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.detail-summary');
    }
}
