<?php

use Illuminate\Support\Facades\Log;
use Jetax\DesignSystem\Support\FontAwesome;

/*
|--------------------------------------------------------------------------
| Prefixo `estilo:` do valor de ícone (SPEC jetax-f2, CT-03, RF-01/Q-09)
|--------------------------------------------------------------------------
*/

it('test_parse_without_prefix_defaults_to_solid', function () {
    expect(FontAwesome::parse('paw'))->toBe(['style' => 'solid', 'name' => 'paw']);
});

it('test_parse_without_prefix_uses_variant', function () {
    expect(FontAwesome::parse('bell', 'regular'))->toBe(['style' => 'regular', 'name' => 'bell']);
});

it('test_parse_with_prefix', function (string $value, string $style, string $name) {
    expect(FontAwesome::parse($value))->toBe(['style' => $style, 'name' => $name]);
})->with([
    ['regular:bell', 'regular', 'bell'],
    ['brands:whatsapp', 'brands', 'whatsapp'],
    ['solid:paw', 'solid', 'paw'],
]);

it('test_parse_invalid_prefix_throws_in_testing', function () {
    FontAwesome::parse('outlined:bell');
})->throws(InvalidArgumentException::class, 'outlined');

it('test_parse_invalid_variant_throws_in_testing', function () {
    FontAwesome::parse('bell', 'light');
})->throws(InvalidArgumentException::class, 'light');

it('test_parse_invalid_prefix_falls_back_to_solid_with_warning_in_production', function () {
    config(['app.env' => 'production']);
    Log::spy();

    expect(FontAwesome::parse('outlined:bell'))->toBe(['style' => 'solid', 'name' => 'bell']);

    Log::shouldHaveReceived('warning')->once();
});

it('test_parse_prefix_equal_to_variant_passes', function () {
    expect(FontAwesome::parse('regular:bell', 'regular'))->toBe(['style' => 'regular', 'name' => 'bell']);
});

it('test_parse_prefix_different_from_variant_throws_in_testing', function () {
    FontAwesome::parse('regular:bell', 'solid');
})->throws(InvalidArgumentException::class, 'regular');

it('test_parse_prefix_different_from_variant_falls_back_to_solid_in_production', function () {
    config(['app.env' => 'production']);
    Log::spy();

    expect(FontAwesome::parse('brands:whatsapp', 'regular'))->toBe(['style' => 'solid', 'name' => 'whatsapp']);

    Log::shouldHaveReceived('warning')->once();
});

it('test_has_rejects_unknown_style', function () {
    expect(FontAwesome::has('paw', 'light'))->toBeFalse();
});
