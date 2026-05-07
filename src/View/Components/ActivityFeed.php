<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActivityFeed extends Component
{
    /**
     * Cria uma nova instância do componente de feed de atividades.
     */
    public function __construct(
        public bool $hasMore = false,
    ) {}

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.activity-feed');
    }
}
