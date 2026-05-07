<?php

test('test_jetax_config_returns_value', function (): void {
    expect(jetax_config('colors.primary'))->toBe('#00497e');
});

test('test_jetax_config_uses_published_config_when_available', function (): void {
    config(['jetax.colors.primary' => '#ff0000']);

    expect(jetax_config('colors.primary'))->toBe('#ff0000');
});
