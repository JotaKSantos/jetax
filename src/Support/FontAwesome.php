<?php

namespace Jetax\DesignSystem\Support;

use Jetax\DesignSystem\View\Components\Concerns\ValidatesVariant;

/**
 * Nomes de ícone do Font Awesome Free (SPEC jetax-f2, RF-08, CT-02, CT-03).
 *
 * O valor de ícone tem a forma `[estilo:]<nome FA canônico>`: `regular:bell`
 * e `brands:whatsapp` pedem `regular` e `brands`; sem prefixo, vale o
 * `variant` informado ou `solid`.
 */
class FontAwesome
{
    use ValidatesVariant;

    /** @var array<int, string> */
    public const STYLES = ['solid', 'regular', 'brands'];

    public const DEFAULT_STYLE = 'solid';

    public const MANIFEST_PATH = __DIR__.'/../../resources/icons/fontawesome-free.json';

    /** @var array{version: string, solid: array<int, string>, regular: array<int, string>, brands: array<int, string>}|null */
    private static ?array $manifest = null;

    /** @var array<string, array<string, true>> */
    private static array $index = [];

    /**
     * Separa o prefixo `estilo:` do nome.
     *
     * Estilo fora de `solid|regular|brands`, ou prefixo diferente de um
     * `variant` explícito, é variante inválida: lança exceção em
     * `local`/`testing` e cai para `solid` com `Log::warning` nos demais.
     *
     * @return array{style: string, name: string}
     *
     * @throws \InvalidArgumentException
     */
    public static function parse(string $value, ?string $variant = null): array
    {
        $validator = new self;
        $name = $value;
        $prefix = null;

        if (str_contains($value, ':')) {
            [$prefix, $name] = explode(':', $value, 2);
        }

        if ($variant !== null) {
            $variant = $validator->validateVariant($variant, self::STYLES, self::DEFAULT_STYLE);
        }

        if ($prefix === null) {
            return ['style' => $variant ?? self::DEFAULT_STYLE, 'name' => $name];
        }

        $style = $validator->validateVariant($prefix, self::STYLES, self::DEFAULT_STYLE);

        if ($variant !== null && $style !== $variant) {
            $style = $validator->validateVariant($style, [$variant], self::DEFAULT_STYLE);
        }

        return ['style' => $style, 'name' => $name];
    }

    /**
     * Diz se o nome canônico existe no manifesto, no estilo informado.
     */
    public static function has(string $name, string $style): bool
    {
        if (! in_array($style, self::STYLES, true)) {
            return false;
        }

        if (self::$index === []) {
            foreach (self::STYLES as $listStyle) {
                self::$index[$listStyle] = array_fill_keys(self::manifest()[$listStyle], true);
            }
        }

        return isset(self::$index[$style][$name]);
    }

    /**
     * Manifesto congelado do pacote (CT-02).
     *
     * @return array{version: string, solid: array<int, string>, regular: array<int, string>, brands: array<int, string>}
     */
    public static function manifest(): array
    {
        return self::$manifest ??= json_decode((string) file_get_contents(self::MANIFEST_PATH), true, flags: JSON_THROW_ON_ERROR);
    }
}
