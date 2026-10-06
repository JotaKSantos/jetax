<?php

/*
|--------------------------------------------------------------------------
| Tabela T-1 (SPEC jetax-f1-alinhamento-v2, RF-01, RF-10, CT-17)
|--------------------------------------------------------------------------
|
| Token => [claro (@theme), escuro (:root.dark)].
|
*/
dataset('tokens_t1', [
    'primary' => ['primary', '#00548d', '#4aa8e8'],
    'primary-container' => ['primary-container', '#00548d', '#005e9c'],
    'secondary' => ['secondary', '#00548d', '#4aa8e8'],
    'secondary-container' => ['secondary-container', '#0a6fb0', '#005e9c'],
    'success' => ['success', '#00a05e', '#00a05e'],
    'warning' => ['warning', '#96570a', '#e0a052'],
    'info' => ['info', '#0f6f96', '#5cc8e8'],
    'error' => ['error', '#b3261e', '#ef7a6d'],
    'danger' => ['danger', '#b3261e', '#ef7a6d'],
    'error-container' => ['error-container', '#f9dedb', '#96331f'],
    'surface' => ['surface', '#eef3f7', '#061726'],
    'surface-dim' => ['surface-dim', '#e3edf4', '#0a2032'],
    'surface-container-lowest' => ['surface-container-lowest', '#ffffff', '#0b2334'],
    'surface-container-low' => ['surface-container-low', '#f3f7fa', '#0a2032'],
    'surface-container' => ['surface-container', '#f3f7fa', '#0e2a40'],
    'surface-container-high' => ['surface-container-high', '#f0f5f9', '#103049'],
    'surface-container-highest' => ['surface-container-highest', '#e3edf4', '#123a4f'],
    'surface-input' => ['surface-input', '#f3f7fa', '#0a2032'],
    'sidebar' => ['sidebar', '#f3f7fa', '#0a2032'],
    'on-surface' => ['on-surface', '#0e2c42', '#eef4f9'],
    'on-surface-variant' => ['on-surface-variant', '#3d5b71', '#93aabd'],
    'on-primary' => ['on-primary', '#ffffff', '#ffffff'],
    'on-primary-fixed' => ['on-primary-fixed', '#00253f', '#d7e8f5'],
    'primary-fixed' => ['primary-fixed', '#d7e8f5', '#d7e8f5'],
    'primary-fixed-dim' => ['primary-fixed-dim', '#a8cfe9', '#8fc9f2'],
    'outline' => ['outline', 'rgba(0,84,141,0.24)', 'rgba(190,218,236,0.19)'],
    'outline-variant' => ['outline-variant', 'rgba(0,84,141,0.15)', 'rgba(190,218,236,0.13)'],
    'inverse-surface' => ['inverse-surface', '#0e2c42', '#eef4f9'],
    'tertiary' => ['tertiary', '#40465e', '#bfc5e0'],
    'secondary-fixed-dim' => ['secondary-fixed-dim', '#9fcaff', '#9fcaff'],
    'success-text' => ['success-text', '#007145', '#3ecb8d'],
    'danger-solid' => ['danger-solid', '#c0392b', '#96331f'],
    'success-solid' => ['success-solid', '#007a48', '#007a48'],
    'neutral-solid' => ['neutral-solid', '#5a788d', '#4d6577'],
    'warning-solid' => ['warning-solid', '#a4600c', '#9a5f16'],
]);

test('light theme (@theme) declares the T-1 value for the token', function (string $token, string $light, string $dark): void {
    expect(jetaxCssTokens('@theme'))->toHaveKey($token)
        ->and(jetaxCssTokens('@theme')[$token])->toBe($light);
})->with('tokens_t1');

test('dark theme (:root.dark) declares the T-1 value for the token', function (string $token, string $light, string $dark): void {
    expect(jetaxCssTokens(':root.dark'))->toHaveKey($token)
        ->and(jetaxCssTokens(':root.dark')[$token])->toBe($dark);
})->with('tokens_t1');

test('both themes declare exactly the same token names', function (): void {
    $light = array_keys(jetaxCssTokens('@theme'));
    $dark = array_keys(jetaxCssTokens(':root.dark'));

    sort($light);
    sort($dark);

    expect($dark)->toBe($light);
});

test('no token is declared twice in the same theme', function (string $block): void {
    $css = preg_replace('#/\*.*?\*/#s', '', file_get_contents(__DIR__.'/../../resources/css/jetax.css'));
    preg_match('/'.preg_quote($block, '/').'\s*\{([^}]*)\}/', $css, $match);
    preg_match_all('/--color-([a-z0-9-]+)\s*:/', $match[1], $names);

    expect($names[1])->toBe(array_values(array_unique($names[1])));
})->with(['@theme', ':root.dark']);

test('palette attention tone (#d98324) is not a token value in either theme', function (): void {
    expect(jetaxCssTokens('@theme'))->not->toContain('#d98324')
        ->and(jetaxCssTokens(':root.dark'))->not->toContain('#d98324');
});
