<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Pagination extends Component
{
    /**
     * Opções de itens por página disponíveis no seletor.
     */
    public const PER_PAGE_OPTIONS = [10, 25, 50, 100];

    /**
     * Número máximo de páginas exibidas antes de reticências.
     */
    public const MAX_VISIBLE_PAGES = 5;

    /**
     * Cria uma nova instância do componente de paginação.
     */
    public function __construct(
        public LengthAwarePaginator $paginator,
        public bool $livewire = false,
        public string|bool $scrollTo = 'body',
        public ?string $perPageModel = null,
    ) {}

    /**
     * Nome do parâmetro de página do paginador (`page` por padrão).
     */
    public function pageName(): string
    {
        return method_exists($this->paginator, 'getPageName')
            ? $this->paginator->getPageName()
            : 'page';
    }

    /**
     * Classes de uma página navegável, iguais nos modos `href` e `livewire`.
     */
    public function pageClasses(): string
    {
        return 'w-8 h-8 flex items-center justify-center rounded-lg text-on-surface-variant hover:bg-surface-container text-xs font-medium transition-all';
    }

    /**
     * Classes da página atual, iguais nos modos `href` e `livewire`.
     */
    public function currentPageClasses(): string
    {
        return 'w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-on-primary text-xs font-bold';
    }

    /**
     * Classes das setas anterior/próxima habilitadas.
     */
    public function arrowClasses(): string
    {
        return 'w-8 h-8 flex items-center justify-center rounded-lg text-outline hover:bg-surface-container transition-all';
    }

    /**
     * Classes das setas anterior/próxima desabilitadas.
     */
    public function disabledArrowClasses(): string
    {
        return 'w-8 h-8 flex items-center justify-center rounded-lg text-outline/40 cursor-not-allowed transition-all';
    }

    /**
     * Trecho Alpine que rola até `scrollTo` ao trocar de página no modo
     * `livewire`. Vazio quando `scrollTo` é `false`.
     */
    public function scrollIntoViewSnippet(): string
    {
        if ($this->scrollTo === false || $this->scrollTo === '') {
            return '';
        }

        $target = $this->scrollTo === true ? 'body' : $this->scrollTo;

        return "(\$el.closest('{$target}') || document.querySelector('{$target}')).scrollIntoView()";
    }

    /**
     * Indica se o seletor de itens por página é exibido. No modo `livewire`
     * ele só aparece com `per-page-model`, a propriedade que recebe o valor.
     */
    public function showsPerPageSelector(): bool
    {
        return ! $this->livewire || $this->perPageModel !== null;
    }

    /**
     * Retorna o número do primeiro item exibido na página atual.
     */
    public function firstItem(): int
    {
        return $this->paginator->firstItem() ?? 0;
    }

    /**
     * Retorna o número do último item exibido na página atual.
     */
    public function lastItem(): int
    {
        return $this->paginator->lastItem() ?? 0;
    }

    /**
     * Retorna o total de itens.
     */
    public function total(): int
    {
        return $this->paginator->total();
    }

    /**
     * Retorna a página atual.
     */
    public function currentPage(): int
    {
        return $this->paginator->currentPage();
    }

    /**
     * Retorna o total de páginas.
     */
    public function lastPage(): int
    {
        return $this->paginator->lastPage();
    }

    /**
     * Indica se está na primeira página.
     */
    public function isFirstPage(): bool
    {
        return $this->paginator->onFirstPage();
    }

    /**
     * Indica se está na última página.
     */
    public function isLastPage(): bool
    {
        return $this->currentPage() >= $this->lastPage();
    }

    /**
     * Retorna a URL da página anterior ou null se não houver.
     */
    public function previousPageUrl(): ?string
    {
        return $this->paginator->previousPageUrl();
    }

    /**
     * Retorna a URL da próxima página ou null se não houver.
     */
    public function nextPageUrl(): ?string
    {
        return $this->paginator->nextPageUrl();
    }

    /**
     * Retorna a URL de uma página específica.
     */
    public function pageUrl(int $page): string
    {
        return $this->paginator->url($page);
    }

    /**
     * Retorna a lista de elementos da paginação com elipses.
     * Retorna um array com inteiros (páginas) e strings ('...') para elipses.
     *
     * @return array<int|string>
     */
    public function elements(): array
    {
        $current = $this->currentPage();
        $last = $this->lastPage();

        if ($last <= self::MAX_VISIBLE_PAGES) {
            return range(1, $last);
        }

        $window = 2;
        $elements = [];

        $start = max(1, $current - $window);
        $end = min($last, $current + $window);

        if ($start > 1) {
            $elements[] = 1;
            if ($start > 2) {
                $elements[] = '...';
            }
        }

        foreach (range($start, $end) as $page) {
            $elements[] = $page;
        }

        if ($end < $last) {
            if ($end < $last - 1) {
                $elements[] = '...';
            }
            $elements[] = $last;
        }

        return $elements;
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.pagination');
    }
}
