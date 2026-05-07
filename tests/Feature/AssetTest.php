<?php

use function PHPUnit\Framework\assertFileExists;

$distPath = __DIR__.'/../../resources/dist/jetax.css';
$cssSourcePath = __DIR__.'/../../resources/css/jetax.css';

it('compiled CSS exists in resources/dist', function () use ($distPath) {
    assertFileExists($distPath);
});

it('CSS source exists in resources/css', function () use ($cssSourcePath) {
    assertFileExists($cssSourcePath);
});

it('compiled CSS contains --jetax-primary variable', function () use ($distPath) {
    $content = file_get_contents($distPath);

    expect($content)->toContain('--jetax-primary');
});

it('CSS source contains @theme block with Tailwind v4 tokens', function () use ($cssSourcePath) {
    $content = file_get_contents($cssSourcePath);

    expect($content)
        ->toContain('@theme')
        ->toContain('--color-primary')
        ->toContain('--font-headline')
        ->toContain('--shadow-ambient');
});

it('compiled CSS contains dark mode overrides', function () use ($distPath) {
    $content = file_get_contents($distPath);

    expect($content)->toContain(':root.dark');
});

it('compiled CSS contains animation keyframes', function () use ($distPath) {
    $content = file_get_contents($distPath);

    expect($content)
        ->toContain('jetax-shimmer')
        ->toContain('jetax-spin')
        ->toContain('jetax-fade-in');
});

it('published asset is accessible after vendor:publish', function () {
    $this->artisan('vendor:publish', ['--tag' => 'jetax-assets', '--force' => true]);

    assertFileExists(public_path('vendor/jetax/jetax.css'));
});

it('CSS source can be published', function () {
    $this->artisan('vendor:publish', ['--tag' => 'jetax-css-source', '--force' => true]);

    assertFileExists(resource_path('css/vendor/jetax/jetax.css'));
});
