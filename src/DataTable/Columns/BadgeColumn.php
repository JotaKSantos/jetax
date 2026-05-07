<?php

namespace Jetax\DesignSystem\DataTable\Columns;

use Closure;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class BadgeColumn extends Column
{
    /**
     * Mapa de valor → variante do badge (ex.: ['draft' => 'neutral', 'published' => 'success']).
     */
    protected array $colorMap = [];

    /**
     * Callback opcional para formatar o label exibido no badge.
     */
    protected ?Closure $formatCallback = null;

    /**
     * Define o mapa de cores (valor → variante).
     */
    public function colors(array $map): static
    {
        $this->colorMap = $map;

        return $this;
    }

    /**
     * Define um callback para formatar o label exibido no badge.
     */
    public function formatUsing(Closure $callback): static
    {
        $this->formatCallback = $callback;

        return $this;
    }

    /**
     * Retorna a variante do badge para o valor informado.
     */
    public function getVariantFor(mixed $value): string
    {
        return $this->colorMap[$value] ?? 'neutral';
    }

    /**
     * Renderiza a célula como um badge x-jetax-badge.
     */
    public function render(mixed $row): mixed
    {
        $value = data_get($row, $this->key);
        $variant = $this->getVariantFor($value);

        $label = $this->formatCallback !== null
            ? ($this->formatCallback)($value)
            : $value;

        $html = Blade::render(
            '<x-jetax-badge variant="{{ $variant }}" style="status">{{ $label }}</x-jetax-badge>',
            ['variant' => $variant, 'label' => $label],
        );

        return new HtmlString($html);
    }
}
