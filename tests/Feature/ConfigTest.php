<?php

test('test_all_default_keys_exist', function () {
    expect(config('jetax.fonts.headline'))->toBe('Manrope')
        ->and(config('jetax.fonts.body'))->toBe('Inter')
        ->and(config('jetax.border_radius'))->toBeArray()
        ->and(config('jetax.sidebar_background'))->toBe('#141A30')
        ->and(config('jetax.dark_mode'))->toBe('class')
        ->and(config('jetax.assets_path'))->toBe('vendor/jetax');
});

test('test_config_can_be_overridden', function () {
    config(['jetax.fonts.headline' => 'Poppins']);

    expect(config('jetax.fonts.headline'))->toBe('Poppins');
});

test('published config has neither the inert colors key nor legacy primary_color', function () {
    $published = require __DIR__.'/../../config/jetax.php';

    expect($published)->not->toHaveKey('colors')
        ->and($published)->not->toHaveKey('primary_color');
});

test('README documents palette override through --color-* in CSS', function () {
    $readme = file_get_contents(__DIR__.'/../../README.md');

    expect($readme)->toContain('### Trocar a paleta por CSS')
        ->and($readme)->toMatch('/:root\s*\{\s*--color-primary:/')
        ->and($readme)->toMatch('/:root\.dark\s*\{\s*--color-primary:/')
        ->and($readme)->not->toContain('Customize via `config/jetax.php`');
});
