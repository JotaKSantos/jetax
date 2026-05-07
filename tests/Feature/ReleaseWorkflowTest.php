<?php

test('release workflow file exists', function () {
    $path = __DIR__.'/../../.github/workflows/release.yml';
    expect(file_exists($path))->toBeTrue();
});

test('release workflow is valid yaml', function () {
    $path = __DIR__.'/../../.github/workflows/release.yml';
    $content = file_get_contents($path);
    // YAML básico: deve conter 'on:', 'jobs:', 'v*'
    expect($content)
        ->toContain('on:')
        ->toContain('jobs:')
        ->toContain("'v*'");
});

test('release workflow triggers on version tags', function () {
    $path = __DIR__.'/../../.github/workflows/release.yml';
    $content = file_get_contents($path);
    expect($content)->toContain('tags:');
});
