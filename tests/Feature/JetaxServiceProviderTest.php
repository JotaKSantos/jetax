<?php

use Illuminate\Support\Facades\Blade;
use Jetax\DesignSystem\JetaxServiceProvider;

test('test_provider_is_registered', function () {
    $loadedProviders = array_keys($this->app->getLoadedProviders());

    expect($loadedProviders)->toContain(JetaxServiceProvider::class);
});

test('test_blade_components_are_registered', function () {
    $aliases = Blade::getClassComponentAliases();

    expect($aliases)->toHaveKey('jetax-layout')
        ->and($aliases)->toHaveKey('jetax-auth-layout');
});

test('test_config_is_merged', function () {
    expect(config('jetax.primary_color'))->toBe('#00497e');
});

test('test_views_are_loaded', function () {
    expect(fn () => view('jetax::components.button'))->not->toThrow(\InvalidArgumentException::class);
});
