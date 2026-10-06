<?php

/*
|--------------------------------------------------------------------------
| Autofill e <option> no jetax.css (SPEC jetax-f1-alinhamento-v2, RF-04)
|--------------------------------------------------------------------------
*/

function jetaxCssRule(string $selector): string
{
    $css = preg_replace('#/\*.*?\*/#s', '', file_get_contents(__DIR__.'/../../resources/css/jetax.css'));

    preg_match('/(?:^|\})\s*'.preg_quote($selector, '/').'\s*(?:,[^{]*)?\{([^}]*)\}/', $css, $match);

    return $match[1] ?? '';
}

test('resting autofill paints background with surface-input and text with on-surface', function (): void {
    $rule = jetaxCssRule('input:-webkit-autofill');

    expect($rule)
        ->toContain('box-shadow: 0 0 0 1000px var(--color-surface-input) inset')
        ->toContain('-webkit-text-fill-color: var(--color-on-surface)')
        ->toContain('caret-color: var(--color-on-surface)');
});

test('autofill covers hover and active with the resting rule', function (): void {
    $css = file_get_contents(__DIR__.'/../../resources/css/jetax.css');

    expect($css)->toMatch('/input:-webkit-autofill,\s*input:-webkit-autofill:hover,\s*input:-webkit-autofill:active\s*\{/');
});

test('focused autofill paints background with surface-container-lowest', function (): void {
    $rule = jetaxCssRule('input:-webkit-autofill:focus');

    expect($rule)
        ->toContain('box-shadow: 0 0 0 1000px var(--color-surface-container-lowest) inset')
        ->toContain('-webkit-text-fill-color: var(--color-on-surface)');
});

test('select option uses surface-container-lowest and on-surface', function (): void {
    $rule = jetaxCssRule('select option');

    expect($rule)
        ->toContain('background-color: var(--color-surface-container-lowest)')
        ->toContain('color: var(--color-on-surface)');
});
