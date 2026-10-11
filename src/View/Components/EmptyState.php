<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

class EmptyState extends Component
{
    use ValidatesVariant;

    /**
     * Tipos disponíveis de empty state.
     */
    public const TYPES = ['empty', 'no-results'];

    /**
     * Tamanhos disponíveis (JETAX-039). `sm` é o vazio de uma linha, com a descrição em
     * destaque no lugar do parágrafo.
     */
    public const SIZES = ['md', 'sm'];

    /**
     * Cria uma nova instância do componente de empty state.
     *
     * `bordered` desenha a moldura tracejada do vazio avulso; o vazio dentro de card
     * fica sem moldura (JETAX-039).
     */
    public function __construct(
        public string $title = '',
        public string $description = '',
        public string $icon = 'inbox',
        public string $type = 'empty',
        public string $size = 'md',
        public bool $bordered = false,
    ) {
        $this->size = $this->validateVariant($size, self::SIZES, 'md', 'size');
    }

    /**
     * Retorna as classes do contêiner: padding do Claude Design e, com `bordered`, a
     * moldura tracejada (JETAX-039).
     */
    public function containerClasses(): string
    {
        $classes = 'flex flex-col items-center justify-center text-center px-5 py-10';

        if ($this->bordered) {
            $classes .= ' border border-dashed border-primary/18 rounded-[10px]';
        }

        return $classes;
    }

    /**
     * Retorna as classes da descrição conforme o tamanho (JETAX-039).
     */
    public function descriptionClasses(): string
    {
        return match ($this->size) {
            'sm' => 'text-sm font-bold text-on-surface',
            default => 'text-on-surface-variant text-sm mb-8 max-w-xs',
        };
    }

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
