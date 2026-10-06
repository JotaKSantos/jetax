<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Editor extends Component
{
    /**
     * Cria uma nova instância do componente de editor rich text.
     *
     * `value` é o conteúdo inicial da área editável (sem ele, o slot serve
     * de fallback). `readonly` trava a edição e a barra sem esmaecer o bloco;
     * `withoutLink` esconde o botão de link.
     */
    public function __construct(
        public string $placeholder = '',
        public string $height = '200px',
        public bool $disabled = false,
        public bool $readonly = false,
        public bool $withoutLink = false,
        public string|Htmlable|null $value = null,
    ) {}

    /**
     * Conteúdo inicial da área editável: `value` quando informado, senão o
     * slot. `Htmlable` entra como está (o Blade não escapa objetos).
     */
    public function initialContent(string $slotContent = ''): string
    {
        return match (true) {
            $this->value instanceof Htmlable => $this->value->toHtml(),
            $this->value !== null => $this->value,
            default => trim($slotContent),
        };
    }

    /**
     * Indica se a edição está travada (`disabled` ou `readonly`).
     */
    public function isLocked(): bool
    {
        return $this->disabled || $this->readonly;
    }

    /**
     * Classes dos botões da barra.
     */
    public function toolbarButtonClasses(): string
    {
        return 'p-1.5 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors disabled:cursor-not-allowed';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.editor');
    }
}
