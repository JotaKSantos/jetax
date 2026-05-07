<?php

namespace Jetax\DesignSystem\DataTable\Columns;

use Closure;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class ActionsColumn extends Column
{
    /**
     * Array ou Closure que retorna as ações por linha.
     *
     * Cada ação: ['key' => string, 'label' => string, 'icon' => string, 'href' => string|Closure|null, 'handler' => string|null]
     */
    protected Closure|array $actions = [];

    /**
     * Número de ações visíveis antes de colapsar o restante num dropdown.
     */
    protected int $collapseAfterCount;

    /**
     * Cria a coluna de ações com chave e label padrão.
     */
    public function __construct(
        protected string $key = 'actions',
        protected string $label = '',
    ) {
        $this->collapseAfterCount = PHP_INT_MAX;
    }

    public static function make(?string $key = null, ?string $label = null): static
    {
        return new static($key ?? 'actions', $label ?? '');
    }

    /**
     * Define as ações da coluna.
     *
     * @param  Closure|array<int, array{key: string, label: string, icon: string, href?: string|Closure|null, handler?: string|null}>  $actions
     */
    public function actions(Closure|array $actions): static
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Define após quantas ações o restante é colapsado num dropdown.
     */
    public function collapseAfter(int $count = 4): static
    {
        $this->collapseAfterCount = $count;

        return $this;
    }

    /**
     * Normaliza e retorna as ações para a linha informada.
     *
     * @return array<int, array{key: string, label: string, icon: string, href: string|null, handler: string|null}>
     */
    public function getActionsFor(mixed $row): array
    {
        $resolved = $this->actions instanceof Closure
            ? ($this->actions)($row)
            : $this->actions;

        return array_map(function (array $action) use ($row): array {
            $href = $action['href'] ?? null;

            if ($href instanceof Closure) {
                $href = $href($row);
            }

            return [
                'key' => $action['key'] ?? '',
                'label' => $action['label'] ?? '',
                'icon' => $action['icon'] ?? '',
                'href' => $href ?? '#',
                'handler' => $action['handler'] ?? null,
            ];
        }, $resolved);
    }

    /**
     * Renderiza a célula com os botões de ação (visíveis + colapso em dropdown).
     */
    public function render(mixed $row): mixed
    {
        $all = $this->getActionsFor($row);
        $visible = array_slice($all, 0, $this->collapseAfterCount);
        $collapsed = array_slice($all, $this->collapseAfterCount);

        $template = <<<'BLADE'
<div class="flex items-center justify-end gap-1 opacity-60 group-hover:opacity-100 transition">
    @foreach($visibleActions as $action)
        <x-jetax-tooltip :content="$action['label']">
            <a href="{{ $action['href'] }}" class="p-1.5 rounded hover:bg-slate-100">
                <x-jetax-icon :name="$action['icon']" size="sm" />
            </a>
        </x-jetax-tooltip>
    @endforeach
    @if(count($collapsedActions) > 0)
        <x-jetax-dropdown>
            <x-slot name="trigger">
                <button type="button" class="p-1.5 rounded hover:bg-slate-100">
                    <x-jetax-icon name="more_vert" size="sm" />
                </button>
            </x-slot>
            @foreach($collapsedActions as $extra)
                <x-jetax-dropdown-item :href="$extra['href']" :icon="$extra['icon']">
                    {{ $extra['label'] }}
                </x-jetax-dropdown-item>
            @endforeach
        </x-jetax-dropdown>
    @endif
</div>
BLADE;

        $html = Blade::render($template, [
            'visibleActions' => $visible,
            'collapsedActions' => $collapsed,
        ]);

        return new HtmlString($html);
    }
}
