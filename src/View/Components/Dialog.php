<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

class Dialog extends Component
{
    use ValidatesVariant;

    /**
     * Variantes disponíveis para o botão de confirmação.
     */
    public const VARIANTS = ['danger', 'warning', 'primary', 'success'];

    /**
     * Larguras do painel com slot `footer`: `wide` (até 680px) e `narrow` (até 480px).
     */
    public const PANEL_WIDTHS = ['wide', 'narrow'];

    /**
     * Cria uma nova instância do componente de dialog.
     *
     * Três arranjos, pelo conteúdo dos slots:
     * - sem slot: ícone da variante, `title`, `message` e dois botões de largura igual;
     * - slot default: corpo livre composto por quem chama (com os ids `{id}-title` e
     *   `{id}-message`) e os botões à direita, no tamanho do texto;
     * - slot `footer`: painel largo ancorado no topo; o slot default é cabeçalho + corpo e o
     *   rodapé, com fundo próprio, é inteiro do `footer`, inclusive os botões.
     */
    public function __construct(
        public string $id = 'dialog',
        public string $title = '',
        public string $message = '',
        public string $confirmLabel = 'Confirmar',
        public string $cancelLabel = 'Cancelar',
        public string $variant = 'danger',
        public bool $confirmDisabled = false,
        public string $panelWidth = 'wide',
    ) {
        $this->panelWidth = $this->validateVariant($panelWidth, self::PANEL_WIDTHS, 'wide', 'panel-width');
    }

    /**
     * Largura máxima do painel com slot `footer`.
     */
    public function footerPanelWidthClass(): string
    {
        return $this->panelWidth === 'narrow' ? 'max-w-[480px]' : 'max-w-[680px]';
    }

    /**
     * Retorna as classes CSS do botão de confirmação baseado na variante.
     */
    public function confirmButtonClasses(): string
    {
        $base = 'inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-150 hover:scale-[1.02] active:scale-95';

        return match ($this->variant) {
            'warning' => $base.' bg-warning-solid hover:opacity-90 text-white',
            'primary' => $base.' bg-primary hover:bg-primary/90 text-white',
            'success' => $base.' bg-success-solid hover:opacity-90 text-white',
            default => $base.' bg-danger-solid hover:opacity-90 text-white', // danger
        };
    }

    /**
     * Classes do estado desabilitado do botão de confirmar (`confirm-disabled`).
     */
    public function confirmDisabledClasses(): string
    {
        return $this->confirmDisabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : '';
    }

    /**
     * Retorna o nome FA do ícone baseado na variante (CT-03).
     */
    public function iconName(): string
    {
        return match ($this->variant) {
            'warning' => 'triangle-exclamation',
            'primary' => 'circle-question',
            'success' => 'circle-check',
            default => 'circle-exclamation', // danger
        };
    }

    /**
     * Retorna as classes CSS do ícone baseado na variante.
     */
    public function iconClasses(): string
    {
        return match ($this->variant) {
            'warning' => 'text-warning',
            'primary' => 'text-primary',
            'success' => 'text-success-text',
            default => 'text-error', // danger
        };
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.dialog');
    }
}
