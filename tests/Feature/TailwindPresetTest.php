<?php

use function PHPUnit\Framework\assertFileExists;

$presetPath = __DIR__.'/../../resources/js/jetax-preset.js';

it('preset file exists at the documented path', function () use ($presetPath) {
    assertFileExists($presetPath);
});

it('all color tokens are defined in the preset', function () use ($presetPath) {
    $content = file_get_contents($presetPath);

    $expectedTokens = [
        'primary',
        'primary-container',
        'primary-fixed',
        'primary-fixed-dim',
        'secondary',
        'secondary-container',
        'secondary-fixed-dim',
        'tertiary',
        'error',
        'error-container',
        'surface',
        'surface-dim',
        'surface-container-lowest',
        'surface-container-low',
        'surface-container',
        'surface-container-high',
        'surface-container-highest',
        'surface-input',
        'on-surface',
        'on-surface-variant',
        'on-primary',
        'on-primary-fixed',
        'outline',
        'outline-variant',
        'inverse-surface',
        'success',
        'warning',
        'info',
        'sidebar',
    ];

    foreach ($expectedTokens as $token) {
        expect($content)->toContain("'$token'");
    }
});

it('font families headline, body and label are defined', function () use ($presetPath) {
    $content = file_get_contents($presetPath);

    expect($content)
        ->toContain("'headline'")
        ->toContain("'body'")
        ->toContain("'label'")
        ->toContain('Manrope')
        ->toContain('Inter');
});

it('border radius tokens are defined', function () use ($presetPath) {
    $content = file_get_contents($presetPath);

    expect($content)
        ->toContain("'DEFAULT'")
        ->toContain("'lg'")
        ->toContain("'xl'")
        ->toContain("'full'");
});

it('box shadow tokens are defined', function () use ($presetPath) {
    $content = file_get_contents($presetPath);

    expect($content)
        ->toContain("'ambient'")
        ->toContain("'ambient-lg'")
        ->toContain("'sidebar'");
});
