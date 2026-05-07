<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActivityFeedItem extends Component
{
    /**
     * Mapeamento de tipos para classes CSS do ícone circular.
     */
    protected const TYPE_MAP = [
        'created'   => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'icon' => 'add_circle'],
        'updated'   => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'icon' => 'edit'],
        'commented' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'icon' => 'chat_bubble'],
        'status'    => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'icon' => 'swap_horiz'],
        'default'   => ['bg' => 'bg-slate-100', 'text' => 'text-slate-500', 'icon' => 'circle'],
    ];

    /**
     * Cria uma nova instância do componente de item de feed de atividades.
     */
    public function __construct(
        public string $icon = '',
        public string $description = '',
        public string $author = '',
        public string $timestamp = '',
        public string $type = 'default',
        public string $dateLabel = '',
    ) {}

    /**
     * Retorna a classe CSS de fundo do container do ícone.
     */
    public function iconBgClass(): string
    {
        return self::TYPE_MAP[$this->type]['bg'] ?? self::TYPE_MAP['default']['bg'];
    }

    /**
     * Retorna a classe CSS de cor do ícone.
     */
    public function iconTextClass(): string
    {
        return self::TYPE_MAP[$this->type]['text'] ?? self::TYPE_MAP['default']['text'];
    }

    /**
     * Retorna o ícone padrão baseado no tipo (quando nenhum ícone é fornecido).
     */
    public function resolvedIcon(): string
    {
        if ($this->icon !== '') {
            return $this->icon;
        }

        return self::TYPE_MAP[$this->type]['icon'] ?? self::TYPE_MAP['default']['icon'];
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.activity-feed-item');
    }
}
