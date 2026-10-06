<?php

/**
 * Returns the body of a `## [x.y.z]` section of the CHANGELOG, up to the next version header.
 */
function changelogSection(string $version): string
{
    $content = file_get_contents(__DIR__.'/../../CHANGELOG.md');
    $start = strpos($content, '## ['.$version.']');

    expect($start)->not->toBeFalse();

    $next = strpos($content, "\n## [", $start + 1);

    return $next === false ? substr($content, $start) : substr($content, $start, $next - $start);
}

/**
 * Returns the body of a `### <title>` subsection inside a CHANGELOG section.
 */
function changelogSubsection(string $section, string $title): string
{
    $start = strpos($section, '### '.$title);

    expect($start)->not->toBeFalse();

    $next = strpos($section, "\n### ", $start + 1);

    return $next === false ? substr($section, $start) : substr($section, $start, $next - $start);
}

/**
 * Returns the `[BREAKING]` entries (list items) of the 2.0.0 section.
 *
 * @return array<int, string>
 */
function changelogBreakingLines(): array
{
    return array_values(array_filter(
        explode("\n", changelogSection('2.0.0')),
        fn (string $line): bool => str_starts_with($line, '- **[BREAKING]'),
    ));
}

/**
 * Returns the UPGRADE.md subsection anchored by `<a id="$anchor"></a>`, up to the next anchor or `## `.
 */
function upgradeSubsection(string $anchor): string
{
    $content = file_get_contents(__DIR__.'/../../UPGRADE.md');
    $start = strpos($content, '<a id="'.$anchor.'"></a>');

    expect($start)->not->toBeFalse();

    preg_match('/\n(<a id="|## )/', $content, $match, PREG_OFFSET_CAPTURE, $start + 1);

    return isset($match[0]) ? substr($content, $start, $match[0][1] - $start) : substr($content, $start);
}

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

test('changelog has a dated 2.0.0 section as the latest release', function () {
    $content = file_get_contents(__DIR__.'/../../CHANGELOG.md');

    expect($content)->toMatch('/^## \[2\.0\.0\] - \d{4}-\d{2}-\d{2}$/m');

    preg_match('/^## \[([^\]]+)\]/m', $content, $first);
    expect($first[1])->toBe('2.0.0');
});

test('changelog 2.0.0 has added, changed, fixed and removed subsections', function () {
    $section = changelogSection('2.0.0');

    expect($section)
        ->toContain('### Added')
        ->toContain('### Changed')
        ->toContain('### Fixed')
        ->toContain('### Removed');
});

test('changelog 2.0.0 cites every resolved issue by id', function (string $issue) {
    $resolved = str_replace(
        changelogSubsection(changelogSection('2.0.0'), 'Adiadas'),
        '',
        changelogSection('2.0.0'),
    );

    expect($resolved)->toContain($issue);
})->with(array_map(
    fn (int $number): string => sprintf('JETAX-%03d', $number),
    [...range(1, 16), ...range(18, 28)],
));

test('changelog 2.0.0 lists JETAX-017 and JETAX-014(c) as deferred', function () {
    $deferred = changelogSubsection(changelogSection('2.0.0'), 'Adiadas');

    expect($deferred)
        ->toContain('JETAX-017')
        ->toContain('JETAX-014(c)');
});

test('changelog 2.0.0 lists JETAX-017 only as deferred', function () {
    $section = changelogSection('2.0.0');
    $deferred = changelogSubsection($section, 'Adiadas');

    expect(str_replace($deferred, '', $section))->not->toContain('JETAX-017');
});

test('changelog 2.0.0 references the upgrade guide', function () {
    expect(changelogSection('2.0.0'))->toContain('(UPGRADE.md)');
});

test('changelog 2.0.0 flags every api break listed in the spec', function (string $needle) {
    $breaking = implode("\n", changelogBreakingLines());

    expect($breaking)->toContain($needle);
})->with([
    'topbar without search' => 'Topbar sem busca',
    'tag renamed to tag-input' => '`x-jetax-tag`',
    'variant, color and position validation' => 'Validação de variante, cor e posição',
    'field height 44px to 40px' => '44px → 40px',
    'token values' => 'Tokens trocados',
    'Dropdown::menuPositionClasses()' => '`Dropdown::menuPositionClasses()`',
    'animations' => 'Animações',
    'jetax.colors' => '`jetax.colors`',
]);

test('upgrade guide exists at the package root', function () {
    expect(file_exists(__DIR__.'/../../UPGRADE.md'))->toBeTrue();
});

test('every breaking change links to an upgrade guide subsection', function () {
    $lines = changelogBreakingLines();

    expect($lines)->toHaveCount(8);

    foreach ($lines as $line) {
        expect($line)->toMatch('/\(UPGRADE\.md#quebra-[a-z0-9-]+\)/');
    }
});

test('upgrade guide has a before, after and how to migrate block per breaking change', function () {
    foreach (changelogBreakingLines() as $line) {
        preg_match('/\(UPGRADE\.md#(quebra-[a-z0-9-]+)\)/', $line, $match);

        $subsection = upgradeSubsection($match[1]);

        expect($subsection)
            ->toMatch('/^### /m')
            ->toContain('**Antes**')
            ->toContain('**Depois**')
            ->toContain('**Como migrar**');
    }
});

test('upgrade guide has no breaking subsection missing from the changelog', function () {
    preg_match_all('/<a id="(quebra-[a-z0-9-]+)"><\/a>/', file_get_contents(__DIR__.'/../../UPGRADE.md'), $anchors);

    $linked = array_map(function (string $line): string {
        preg_match('/\(UPGRADE\.md#(quebra-[a-z0-9-]+)\)/', $line, $match);

        return $match[1];
    }, changelogBreakingLines());

    expect($anchors[1])->toEqualCanonicalizing($linked);
});

test('upgrade guide summarizes the component contracts and the animations config', function () {
    $guide = file_get_contents(__DIR__.'/../../UPGRADE.md');

    foreach (range(1, 17) as $number) {
        expect($guide)->toContain(sprintf('CT-%02d', $number));
    }

    expect($guide)->toContain('jetax.animations');
});

test('readme links to the upgrade guide', function () {
    expect(file_get_contents(__DIR__.'/../../README.md'))->toContain('(UPGRADE.md)');
});
