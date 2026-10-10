<?php

namespace Jetax\DesignSystem\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Jetax\DesignSystem\Support\FontAwesome;

/**
 * Ícone da webfont do Font Awesome Free (SPEC jetax-f2, RF-01, RF-02, CT-01, CT-05).
 *
 * O `name` aceita o prefixo `estilo:` (`regular:bell`, `brands:whatsapp`);
 * sem prefixo, vale o `variant` (default `solid`).
 */
class Icon extends Component
{
    /**
     * Classe de tamanho por `size` nomeado: o valor da v2 (16/20/24/32)
     * dividido por 1,35 e arredondado (CT-05).
     */
    public const SIZES = [
        'sm' => 'text-[12px]',
        'md' => 'text-[15px]',
        'lg' => 'text-[18px]',
        'xl' => 'text-[24px]',
    ];

    /**
     * Fator de equivalência "tamanho Material ≈ tamanho FA × 1,35" (JETAX-017).
     */
    public const SIZE_FACTOR = 1.35;

    /**
     * Estilo resolvido (`solid`, `regular` ou `brands`).
     */
    public string $iconStyle;

    /**
     * Nome FA canônico, sem o prefixo de estilo.
     */
    public string $iconName;

    /**
     * Cria uma nova instância do componente de ícone.
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        public string $name,
        public string|int $size = 'md',
        public ?string $variant = null,
    ) {
        ['style' => $this->iconStyle, 'name' => $this->iconName] = FontAwesome::parse($name, $variant);
    }

    /**
     * Classes FA do elemento, com a classe de tamanho quando `size` é nomeado.
     */
    public function iconClasses(): string
    {
        $classes = "fa-{$this->iconStyle} fa-{$this->iconName}";

        if (is_numeric($this->size)) {
            return $classes;
        }

        return $classes.' '.(self::SIZES[$this->size] ?? self::SIZES['md']);
    }

    /**
     * `font-size` inline do `size` numérico (RF-02, Q-04); nulo para tamanho nomeado.
     */
    public function inlineFontSize(): ?string
    {
        if (! is_numeric($this->size)) {
            return null;
        }

        return 'font-size:'.(int) round(((float) $this->size) / self::SIZE_FACTOR).'px';
    }

    /**
     * Retorna a view do componente.
     */
    public function render(): View
    {
        return view('jetax::components.icon');
    }
}
