<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    /**
     * Mapeamento de tamanhos nomeados para pixels.
     */
    public const SIZES = [
        'sm' => 16,
        'md' => 20,
        'lg' => 24,
        'xl' => 32,
    ];

    /**
     * Cria uma nova instância do componente de ícone.
     */
    public function __construct(
        public string $name,
        public string|int $size = 'md',
        public int $weight = 400,
        public bool $fill = false,
    ) {}

    /**
     * Retorna o valor de font-size em pixels baseado no tamanho configurado.
     * Aceita valores nomeados (sm, md, lg, xl) ou valores numéricos diretos.
     */
    public function sizeClasses(): string
    {
        if (is_numeric($this->size)) {
            return 'font-size: '.(int) $this->size.'px';
        }

        $px = self::SIZES[$this->size] ?? self::SIZES['md'];

        return 'font-size: '.$px.'px';
    }

    /**
     * Retorna a string CSS font-variation-settings para controlar
     * o preenchimento (FILL) e a espessura (wght) do ícone.
     */
    public function fontVariationSettings(): string
    {
        $fill = $this->fill ? 1 : 0;

        return "'FILL' {$fill}, 'wght' {$this->weight}";
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.icon');
    }
}
