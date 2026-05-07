<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\View\Component;

class Skeleton extends Component
{
    /**
     * Cria uma nova instância do componente skeleton de carregamento.
     */
    public function __construct(
        public string $width = 'full',
        public string $height = '4',
        public bool $rounded = false,
    ) {}

    /**
     * Retorna a classe de largura baseada no valor configurado.
     */
    public function widthClass(): string
    {
        return match ($this->width) {
            'full' => 'w-full',
            '1/2'  => 'w-1/2',
            '1/3'  => 'w-1/3',
            '2/3'  => 'w-2/3',
            '1/4'  => 'w-1/4',
            '3/4'  => 'w-3/4',
            '16'   => 'w-16',
            '24'   => 'w-24',
            '32'   => 'w-32',
            '48'   => 'w-48',
            '64'   => 'w-64',
            default => 'w-full',
        };
    }

    /**
     * Retorna a classe de altura baseada no valor configurado.
     */
    public function heightClass(): string
    {
        return match ($this->height) {
            '2'  => 'h-2',
            '3'  => 'h-3',
            '4'  => 'h-4',
            '6'  => 'h-6',
            '8'  => 'h-8',
            '10' => 'h-10',
            '12' => 'h-12',
            '16' => 'h-16',
            '24' => 'h-24',
            '32' => 'h-32',
            '48' => 'h-48',
            default => 'h-4',
        };
    }

    /**
     * Retorna as classes CSS de dimensão e borda para o skeleton.
     */
    public function skeletonClasses(): string
    {
        $classes = [
            $this->widthClass(),
            $this->heightClass(),
            $this->rounded ? 'rounded-full' : 'rounded-lg',
        ];

        return implode(' ', $classes);
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('jetax::components.skeleton');
    }
}
