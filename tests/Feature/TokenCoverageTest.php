<?php

use Symfony\Component\Finder\Finder;

/*
|--------------------------------------------------------------------------
| Cobertura de tokens (SPEC jetax-f1-alinhamento-v2, RF-02, CT-17)
|--------------------------------------------------------------------------
|
| Todo token de cor que um componente do pacote consome, por classe
| (bg|text|border|ring|from|to)-<token> ou por var(--color-<token>), existe
| nos dois temas do jetax.css.
|
*/

const TAILWIND_NATIVE_COLORS = [
    'slate', 'gray', 'zinc', 'neutral', 'stone', 'red', 'orange', 'amber', 'yellow', 'lime',
    'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia',
    'pink', 'rose', 'white', 'black', 'transparent', 'current', 'inherit',
];

/**
 * Sufixos das mesmas famílias de utilitário que não são cor: tamanho de
 * texto, alinhamento, espessura e estilo de borda, offset de ring, imagem
 * e posição de fundo.
 */
const NON_COLOR_SUFFIXES = [
    'xs', 'sm', 'base', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl', '8xl', '9xl',
    'left', 'center', 'right', 'justify', 'start', 'end', 'wrap', 'nowrap', 'balance', 'pretty',
    'ellipsis', 'clip', 'solid', 'dashed', 'dotted', 'double', 'hidden', 'none', 'collapse', 'separate',
    'inset', 'offset', 'fixed', 'local', 'scroll', 'origin', 'repeat', 'no', 'auto', 'cover', 'contain',
    'top', 'bottom', 'gradient', 'linear', 'radial', 'conic', 'blend',
    't', 'r', 'b', 'l', 'x', 'y', 's', 'e',
];

/**
 * @return array<int, string>
 */
function consumedColorTokens(): array
{
    $root = __DIR__.'/../..';
    $finder = Finder::create()->files()
        ->in([$root.'/resources/views/components', $root.'/src'])
        ->name(['*.php']);

    $tokens = [];

    foreach ($finder as $file) {
        $contents = $file->getContents();

        preg_match_all('/(?<![\w-])(?:bg|text|border|ring|from|to)-((?:[trblxyse]-)?[a-z][a-z0-9-]*)(?=[\s"\'\/\]\}\)`,;.]|$)/m', $contents, $classes);
        preg_match_all('/var\(--color-([a-z][a-z0-9-]*)\)/', $contents, $variables);

        foreach ([...$classes[1], ...$variables[1]] as $candidate) {
            $candidate = preg_replace('/^[trblxyse]-/', '', $candidate);
            $family = explode('-', $candidate)[0];

            if (in_array($family, TAILWIND_NATIVE_COLORS, true)
                || in_array($family, NON_COLOR_SUFFIXES, true)
                || preg_match('/^\d/', $candidate)) {
                continue;
            }

            $tokens[$candidate] = true;
        }
    }

    ksort($tokens);

    return array_keys($tokens);
}

test('scan finds the tokens consumed by components', function (): void {
    $tokens = consumedColorTokens();

    expect($tokens)->toContain('primary', 'on-surface', 'surface-container-lowest', 'outline-variant', 'sidebar');

    foreach (['sm', 'center', 'slate-500', 'white', 'b', 't', 'transparent', 'gradient-to-br'] as $notToken) {
        expect($tokens)->not->toContain($notToken);
    }
});

test('every token consumed by components exists in the light theme', function (): void {
    $missing = array_values(array_diff(consumedColorTokens(), array_keys(jetaxCssTokens('@theme'))));

    expect($missing)->toBe([]);
});

test('every token consumed by components exists in the dark theme', function (): void {
    $missing = array_values(array_diff(consumedColorTokens(), array_keys(jetaxCssTokens(':root.dark'))));

    expect($missing)->toBe([]);
});
