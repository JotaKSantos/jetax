<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmptyState extends Component
{
    /**
     * Tipos disponíveis de empty state.
     */
    public const TYPES = ['empty', 'no-results'];

    /**
     * Cria uma nova instância do componente de empty state.
     */
    public function __construct(
        public string $title = '',
        public string $description = '',
        public string $icon = 'inbox',
        public string $type = 'empty',
    ) {}

    /**
     * Retorna as classes do ícone baseadas no tipo.
     */
    public function iconColorClasses(): string
    {
        return match ($this->type) {
            'no-results' => 'text-outline-variant',
            default => 'text-outline',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.empty-state');
    }
}
