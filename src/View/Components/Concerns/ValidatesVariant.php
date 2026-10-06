<?php

namespace Jetax\DesignSystem\View\Components\Concerns;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

trait ValidatesVariant
{
    /**
     * Valida um valor de prop contra a lista de valores aceitos pelo componente.
     *
     * Em `local` e `testing`, um valor fora da lista lança exceção, para o erro
     * aparecer no desenvolvimento. Nos demais ambientes a tela não quebra: o
     * componente registra um `Log::warning` e usa o valor padrão.
     *
     * @param  array<int, string>  $allowed
     *
     * @throws InvalidArgumentException
     */
    protected function validateVariant(string $value, array $allowed, string $fallback, string $prop = 'variant'): string
    {
        if (in_array($value, $allowed, true)) {
            return $value;
        }

        $message = sprintf(
            '%s: valor "%s" inválido para "%s". Valores aceitos: %s.',
            class_basename(static::class),
            $value,
            $prop,
            implode(', ', $allowed),
        );

        if (in_array(config('app.env'), ['local', 'testing'], true)) {
            throw new InvalidArgumentException($message);
        }

        Log::warning($message, [
            'component' => static::class,
            'prop' => $prop,
            'value' => $value,
            'fallback' => $fallback,
        ]);

        return $fallback;
    }
}
