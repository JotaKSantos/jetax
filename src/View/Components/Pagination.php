<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
    ) {}

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
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.pagination');
    }
}
