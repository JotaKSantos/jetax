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

test('changelog has a dated 2.0.0 section', function () {
    $content = file_get_contents(__DIR__.'/../../CHANGELOG.md');

    expect($content)->toMatch('/^## \[2\.0\.0\] - \d{4}-\d{2}-\d{2}$/m');
});

test('changelog 2.0.0 section is unchanged by the 3.0.0 release', function () {
    expect(hash('sha256', changelogSection('2.0.0')))
        ->toBe('4a2e0f1b621885190d66212ca5ab3e21614988c7f115840560905c69a52ebd94');
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

test('changelog has a dated 3.0.0 section as the latest release', function () {
    $content = file_get_contents(__DIR__.'/../../CHANGELOG.md');

    expect($content)->toMatch('/^## \[3\.0\.0\] - \d{4}-\d{2}-\d{2}$/m');

    preg_match('/^## \[([^\]]+)\]/m', $content, $first);
    expect($first[1])->toBe('3.0.0');
});

test('changelog 3.0.0 has changed, fixed, removed and added subsections', function () {
    $section = changelogSection('3.0.0');

    expect($section)
        ->toContain('### Changed')
        ->toContain('### Fixed')
        ->toContain('### Removed')
        ->toContain('### Added');
});

test('changelog 3.0.0 flags the icon system change as breaking', function () {
    $changed = changelogSubsection(changelogSection('3.0.0'), 'Changed');

    expect($changed)->toMatch('/^- \*\*\[BREAKING\] Sistema de ícones/m');
});

test('changelog 3.0.0 cites the deferred issues as fixed', function (string $issue) {
    expect(changelogSubsection(changelogSection('3.0.0'), 'Fixed'))->toContain($issue);
})->with(['JETAX-017', 'JETAX-014(c)']);

test('changelog 3.0.0 lists the removed icon props and the material stylesheet', function () {
    $removed = changelogSubsection(changelogSection('3.0.0'), 'Removed');

    expect($removed)
        ->toContain('`weight`')
        ->toContain('`fill`')
        ->toContain('Folha do Material Symbols');
});

test('changelog 3.0.0 lists the variant prop, the style prefix, the manifest and the helper as added', function () {
    $added = changelogSubsection(changelogSection('3.0.0'), 'Added');

    expect($added)
        ->toContain('`variant`')
        ->toContain('`estilo:`')
        ->toContain('resources/icons/fontawesome-free.json')
        ->toContain('`Support\\FontAwesome`');
});

test('changelog 3.0.0 references the upgrade guide', function () {
    expect(changelogSection('3.0.0'))->toContain('(UPGRADE.md)');
});

test('upgrade guide has the 2.x to 3.0 section header', function () {
    $guide = file_get_contents(__DIR__.'/../../UPGRADE.md');

    expect($guide)
        ->toContain('<a id="guia-2x-30"></a>')
        ->toMatch('/^# Guia de migração 2\.x → 3\.0$/m');
});

test('upgrade guide 2.x to 3.0 has a before, after and how to migrate block per breaking change', function (string $anchor) {
    $subsection = upgradeSubsection($anchor);

    expect($subsection)
        ->toMatch('/^### /m')
        ->toContain('**Antes**')
        ->toContain('**Depois**')
        ->toContain('**Como migrar**');
})->with([
    'markup' => 'v3-marcacao',
    'weight and fill' => 'v3-weight-fill',
    'variant' => 'v3-variant',
    'icon with style prefix' => 'v3-icon-estilo',
    'css import in a layer' => 'v3-import-css',
    'sizes and x-text' => 'v3-tamanhos',
]);

test('every 3.0.0 breaking change links to an upgrade guide subsection', function () {
    $breaking = array_filter(
        explode("\n", changelogSection('3.0.0')),
        fn (string $line): bool => str_starts_with($line, '- **[BREAKING]'),
    );

    expect($breaking)->toHaveCount(5);

    foreach ($breaking as $line) {
        expect($line)->toMatch('/\(UPGRADE\.md#v3-[a-z0-9-]+\)/');
    }
});

test('changelog 3.0.0 and the upgrade guide share the same six 3.0 subsections', function () {
    preg_match_all('/\(UPGRADE\.md#(v3-[a-z0-9-]+)\)/', changelogSection('3.0.0'), $links);
    preg_match_all('/<a id="(v3-[a-z0-9-]+)"><\/a>/', file_get_contents(__DIR__.'/../../UPGRADE.md'), $anchors);

    expect($anchors[1])
        ->toHaveCount(6)
        ->toEqualCanonicalizing($links[1]);
});

test('upgrade guide documents the size equivalence rule and the manifest command', function () {
    $guide = file_get_contents(__DIR__.'/../../UPGRADE.md');

    expect($guide)
        ->toContain('1,35')
        ->toContain('generate-fontawesome-manifest');
});

test('upgrade guide 2.x to 3.0 covers the class binding in place of x-text', function () {
    expect(upgradeSubsection('v3-tamanhos'))
        ->toContain('x-text')
        ->toContain(':class');
});

test('readme links to the 2.x to 3.0 upgrade section', function () {
    expect(file_get_contents(__DIR__.'/../../README.md'))->toContain('(UPGRADE.md#guia-2x-30)');
});
