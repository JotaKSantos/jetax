<?php

test('test_all_default_keys_exist', function () {
    expect(config('jetax.colors'))->toBeArray()
        ->and(config('jetax.fonts.headline'))->toBe('Manrope')
        ->and(config('jetax.fonts.body'))->toBe('Inter')
        ->and(config('jetax.border_radius'))->toBeArray()
        ->and(config('jetax.sidebar_background'))->toBe('#141A30')
        ->and(config('jetax.dark_mode'))->toBe('class')
        ->and(config('jetax.assets_path'))->toBe('vendor/jetax');
});

test('test_config_can_be_overridden', function () {
    config(['jetax.colors.primary' => '#ff0000']);

    expect(config('jetax.colors.primary'))->toBe('#ff0000');
});
