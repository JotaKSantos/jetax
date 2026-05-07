<?php

namespace Jetax\DesignSystem\DataTable\Columns;

use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;

class DateColumn extends Column
{
    /**
     * Formato de exibição da data (padrão pt-BR).
     */
    protected string $format = 'd/m/Y';

    /**
     * Define o formato de exibição da data.
     */
    public function format(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Retorna o formato configurado.
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Renderiza a célula como um <span> com a data formatada em pt-BR.
     */
    public function render(mixed $row): mixed
    {
        $value = data_get($row, $this->key);

        if ($value === null || $value === '') {
            return '';
        }

        $formatted = Carbon::parse($value)->translatedFormat($this->format);

        return new HtmlString('<span>' . e($formatted) . '</span>');
    }
}
