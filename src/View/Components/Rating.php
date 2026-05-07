<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Rating extends Component
{
    /**
     * Mapeamento de tamanhos nomeados para pixels.
     */
    public const SIZES = [
        'sm' => 16,
        'md' => 24,
        'lg' => 32,
    ];

    /**
     * Cria uma nova instância do componente de avaliação por estrelas.
     */
    public function __construct(
        public int $max = 5,
        public int|float $value = 0,
        public string $size = 'md',
        public bool $readonly = false,
        public string $name = '',
    ) {}

    /**
     * Retorna o valor em pixels para o tamanho configurado.
     */
    public function sizeClasses(): string
    {
        $px = self::SIZES[$this->size] ?? self::SIZES['md'];

        return $px.'px';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.rating');
    }
}
