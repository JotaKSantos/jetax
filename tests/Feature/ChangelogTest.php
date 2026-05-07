<?php

test('changelog file exists', function () {
    expect(file_exists(__DIR__.'/../../CHANGELOG.md'))->toBeTrue();
});

test('changelog has version 1.0.0 section', function () {
    $content = file_get_contents(__DIR__.'/../../CHANGELOG.md');
    expect($content)->toContain('## [1.0.0]');
});

test('changelog follows keep a changelog format', function () {
    $content = file_get_contents(__DIR__.'/../../CHANGELOG.md');
    expect($content)
        ->toContain('# Changelog')
        ->toContain('### Added');
});
