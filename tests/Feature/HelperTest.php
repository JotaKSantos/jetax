<?php

test('test_jetax_config_returns_value', function (): void {
    expect(jetax_config('fonts.headline'))->toBe('Manrope');
});

test('test_jetax_config_uses_published_config_when_available', function (): void {
    config(['jetax.fonts.headline' => 'Poppins']);

    expect(jetax_config('fonts.headline'))->toBe('Poppins');
});
