<?php

/*
|--------------------------------------------------------------------------
| Contraste WCAG dos tokens (SPEC jetax-f1-alinhamento-v2, RNF-01, RF-10)
|--------------------------------------------------------------------------
|
| A razão sai dos valores declarados em jetax.css, nos dois temas. O par
| on-primary × success (botão verde do mockup, ≈ 3,4:1) fica fora do gate.
|
*/

function relativeLuminance(string $hex): float
{
    $hex = ltrim($hex, '#');

    if (! preg_match('/^[0-9a-f]{6}$/i', $hex)) {
        throw new InvalidArgumentException("Cor sólida esperada, recebida: #{$hex}");
    }

    $channels = array_map(function (string $pair): float {
        $value = hexdec($pair) / 255;

        return $value <= 0.03928 ? $value / 12.92 : (($value + 0.055) / 1.055) ** 2.4;
    }, str_split($hex, 2));

    return 0.2126 * $channels[0] + 0.7152 * $channels[1] + 0.0722 * $channels[2];
}

function contrastRatio(string $foreground, string $background): float
{
    $lighter = max(relativeLuminance($foreground), relativeLuminance($background));
    $darker = min(relativeLuminance($foreground), relativeLuminance($background));

    return ($lighter + 0.05) / ($darker + 0.05);
}

function tokenOrHex(array $tokens, string $color): string
{
    return str_starts_with($color, '#') ? $color : $tokens[$color];
}

dataset('pares_rnf01', [
    'on-surface × surface' => ['on-surface', 'surface'],
    'on-surface × surface-container-lowest' => ['on-surface', 'surface-container-lowest'],
    'on-surface-variant × surface-container-lowest' => ['on-surface-variant', 'surface-container-lowest'],
    'primary × surface-container-lowest' => ['primary', 'surface-container-lowest'],
    'success-text × surface-container-lowest' => ['success-text', 'surface-container-lowest'],
    'warning × surface-container-lowest' => ['warning', 'surface-container-lowest'],
    'info × surface-container-lowest' => ['info', 'surface-container-lowest'],
    'error × surface-container-lowest' => ['error', 'surface-container-lowest'],
    'white × danger-solid' => ['#ffffff', 'danger-solid'],
    'white × success-solid' => ['#ffffff', 'success-solid'],
    'white × neutral-solid' => ['#ffffff', 'neutral-solid'],
    'white × warning-solid' => ['#ffffff', 'warning-solid'],
]);

test('pair reaches WCAG contrast of at least 4.5:1 in the theme', function (string $block, string $foreground, string $background): void {
    $tokens = jetaxCssTokens($block);

    $ratio = contrastRatio(tokenOrHex($tokens, $foreground), tokenOrHex($tokens, $background));

    expect($ratio)->toBeGreaterThanOrEqual(4.5);
})->with(['light' => '@theme', 'dark' => ':root.dark'])->with('pares_rnf01');

test('contrast calculation matches WCAG reference values', function (): void {
    expect(round(contrastRatio('#000000', '#ffffff'), 2))->toBe(21.0)
        ->and(round(contrastRatio('#ffffff', '#ffffff'), 2))->toBe(1.0)
        ->and(contrastRatio('#ffffff', '#d98324'))->toBeLessThan(4.5);
});
