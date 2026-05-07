<?php

it('Google Fonts link is rendered when font_source is google', function () {
    config()->set('jetax.font_source', 'google');

    $html = view('jetax::partials.fonts')->render();

    expect($html)
        ->toContain('fonts.googleapis.com')
        ->toContain('Manrope')
        ->toContain('Inter')
        ->toContain('Material+Symbols+Outlined');
});

it('font link is not rendered when font_source is false', function () {
    config()->set('jetax.font_source', false);

    $html = view('jetax::partials.fonts')->render();

    expect(trim($html))->toBeEmpty();
});

it('font link is not rendered when font_source is local', function () {
    config()->set('jetax.font_source', 'local');

    $html = view('jetax::partials.fonts')->render();

    expect(trim($html))->toBeEmpty();
});

it('font_source config key exists with google as default', function () {
    expect(config('jetax.font_source'))->toBe('google');
});

it('Google Fonts link includes correct Manrope weights', function () {
    config()->set('jetax.font_source', 'google');

    $html = view('jetax::partials.fonts')->render();

    expect($html)
        ->toContain('Manrope:wght@300;600;700;800');
});

it('Google Fonts link includes correct Inter weights', function () {
    config()->set('jetax.font_source', 'google');

    $html = view('jetax::partials.fonts')->render();

    expect($html)
        ->toContain('Inter:wght@400;500;600');
});

it('Google Fonts link includes preconnect hints', function () {
    config()->set('jetax.font_source', 'google');

    $html = view('jetax::partials.fonts')->render();

    expect($html)
        ->toContain('preconnect')
        ->toContain('fonts.gstatic.com');
});
