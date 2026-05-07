<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Tamanhos disponíveis para o modal.
     */
    public const SIZES = ['sm', 'md', 'lg', 'fullscreen'];

    /**
     * Cria uma nova instância do componente de modal.
     */
    public function __construct(
        public string $id = 'modal',
        public string $size = 'md',
        public bool $highRisk = false,
    ) {}

    /**
     * Retorna as classes CSS de largura para o tamanho do modal.
     */
    public function sizeClasses(): string
    {
        return match ($this->size) {
            'sm'         => 'max-w-xs',
            'lg'         => 'max-w-4xl',
            'fullscreen' => 'w-full max-w-full h-full',
            default      => 'max-w-xl',
        };
    }

    /**
     * Retorna as classes CSS de borda para a variante high-risk.
     */
    public function containerClasses(): string
    {
        $base = 'bg-white rounded-xl shadow-2xl overflow-hidden border';

        if ($this->highRisk) {
            return $base.' border-4 border-amber-400/20';
        }

        return $base.' border-slate-100';
    }

    /**
     * Retorna as classes CSS do header.
     */
    public function headerClasses(): string
    {
        if ($this->highRisk) {
            return 'px-6 py-4 flex justify-between items-center bg-amber-50 text-amber-800';
        }

        return 'px-6 py-4 flex justify-between items-center bg-white';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.modal');
    }
}
