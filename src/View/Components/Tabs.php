<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Tabs extends Component
{
    /**
     * Variantes disponíveis para o componente de tabs.
     */
    public const VARIANTS = ['underline', 'pill'];

    /**
     * Cria uma nova instância do componente Tabs.
     *
     * @param  array<int, array{name: string, label: string, count?: int}>  $tabs
     */
    public function __construct(
        public array $tabs = [],
        public string $variant = 'underline',
        public string $wireModel = '',
    ) {}

    /**
     * Retorna o nome da primeira tab para definir o estado inicial do Alpine.
     */
    public function firstTabName(): string
    {
        if (empty($this->tabs)) {
            return '';
        }

        return $this->tabs[0]['name'] ?? '';
    }

    /**
     * Retorna as classes do container de navegação conforme a variante.
     */
    public function navClasses(): string
    {
        return match ($this->variant) {
            'pill' => 'inline-flex p-1 bg-surface-container rounded-full',
            default => 'border-b border-slate-100',
        };
    }

    /**
     * Retorna as classes do wrapper interno de navegação conforme a variante.
     */
    public function navInnerClasses(): string
    {
        return match ($this->variant) {
            'pill' => '',
            default => 'flex gap-8 -mb-px',
        };
    }

    /**
     * Retorna as classes do botão/link de tab ativo conforme a variante.
     */
    public function activeTabClasses(): string
    {
        return match ($this->variant) {
            'pill' => 'px-6 py-2 bg-white text-primary font-bold text-xs rounded-full shadow-sm',
            default => 'pb-4 px-1 text-sm font-semibold text-primary border-b-2 border-primary',
        };
    }

    /**
     * Retorna as classes do botão/link de tab inativo conforme a variante.
     */
    public function inactiveTabClasses(): string
    {
        return match ($this->variant) {
            'pill' => 'px-6 py-2 text-slate-500 font-bold text-xs rounded-full hover:text-primary transition-colors',
            default => 'pb-4 px-1 text-sm font-medium text-slate-500 hover:text-primary transition-colors border-b-2 border-transparent hover:border-slate-300',
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.tabs');
    }
}
