<?php

use Jetax\DesignSystem\Support\FontAwesome;

/**
 * Carregamento sem folha de ícone (SPEC jetax-f2, RF-03, CT-04, JETAX-017).
 *
 * O pacote não carrega o Font Awesome: quem importa a folha é o consumidor,
 * em cascade layer. O pacote só documenta esse import no README.
 */
function jetaxPackagePath(string $path): string
{
    return __DIR__.'/../../'.$path;
}

/**
 * Blocos de nível superior do CSS que não estão dentro de `@layer`, sem comentários.
 *
 * @return array<int, string>
 */
function cssBlocksOutsideLayer(string $css): array
{
    $css = preg_replace('#/\*.*?\*/#s', '', $css);
    $blocks = [];
    $depth = 0;
    $start = 0;
    $length = strlen($css);

    for ($i = 0; $i < $length; $i++) {
        $char = $css[$i];

        if ($char === ';' && $depth === 0) {
            $start = $i + 1;
        } elseif ($char === '{') {
            $depth++;
        } elseif ($char === '}') {
            $depth--;

            if ($depth === 0) {
                $block = trim(substr($css, $start, $i - $start + 1));

                if (! str_starts_with($block, '@layer')) {
                    $blocks[] = $block;
                }

                $start = $i + 1;
            }
        }
    }

    return $blocks;
}

it('test_fonts_partial_has_no_icon_stylesheet', function () {
    config()->set('jetax.font_source', 'google');

    $html = view('jetax::partials.fonts')->render();

    expect($html)->toContain('Manrope')
        ->toContain('Inter')
        ->toContain('preconnect')
        ->not->toContain('Material')
        ->not->toContain('fontawesome')
        ->not->toContain('font-awesome');
});

it('test_package_views_never_link_an_icon_stylesheet', function () {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(jetaxPackagePath('resources/views'), FilesystemIterator::SKIP_DOTS));
    $links = [];

    foreach ($files as $file) {
        preg_match_all('/<link\b[^>]*>/i', (string) file_get_contents($file->getPathname()), $matches);

        foreach ($matches[0] as $link) {
            if (preg_match('/material|fontawesome|font-awesome/i', $link)) {
                $links[] = $file->getFilename().': '.$link;
            }
        }
    }

    expect($links)->toBe([]);
});

it('test_jetax_css_has_no_icon_stylesheet_import', function () {
    $css = preg_replace('#/\*.*?\*/#s', '', (string) file_get_contents(jetaxPackagePath('resources/css/jetax.css')));

    preg_match_all('/@import\b[^;]*;/i', $css, $imports);

    $iconImports = array_filter($imports[0], fn (string $import): bool => (bool) preg_match('/material|fontawesome|font-awesome|icon/i', $import));

    expect($iconImports)->toBe([]);
});

it('test_jetax_css_has_no_icon_rule_outside_layer', function () {
    $blocks = cssBlocksOutsideLayer((string) file_get_contents(jetaxPackagePath('resources/css/jetax.css')));

    expect($blocks)->not->toBeEmpty();

    foreach ($blocks as $block) {
        expect($block)->not->toContain('.fa-')
            ->not->toContain('.material-symbols');
    }
});

it('test_css_block_parser_flags_icon_rule_outside_layer', function () {
    $blocks = cssBlocksOutsideLayer('@layer base { .fa-solid { font-size: 1em; } } /* .fa-x {} */ .fa-paw { color: red; } @import "x.css";');

    expect($blocks)->toBe(['.fa-paw { color: red; }']);
});

it('test_readme_documents_font_awesome_import_in_layer_before_tailwind', function () {
    $readme = (string) file_get_contents(jetaxPackagePath('README.md'));

    preg_match_all('/```css\n(.*?)```/s', $readme, $cssBlocks);

    $layeredBeforeTailwind = array_filter($cssBlocks[1], function (string $block): bool {
        $faImport = strpos($block, '@import "@fortawesome/fontawesome-free/css/all.min.css" layer(base);');
        $tailwindImport = strpos($block, '@import "tailwindcss";');

        return $faImport !== false && $tailwindImport !== false && $faImport < $tailwindImport;
    });

    expect($readme)->toContain('layer(')
        ->and($layeredBeforeTailwind)->not->toBeEmpty();

    preg_match_all('/@import\b[^;\n]*fontawesome[^;\n]*;/i', $readme, $faImports);

    foreach ($faImports[0] as $import) {
        expect($import)->toContain('layer(base)')
            ->not->toContain('http');
    }
});

it('test_readme_pins_the_manifest_font_awesome_version', function () {
    $readme = (string) file_get_contents(jetaxPackagePath('README.md'));
    $version = FontAwesome::manifest()['version'];

    preg_match_all('/npm install\b[^\n]*@fortawesome\/fontawesome-free@(\S+)/', $readme, $installs);

    expect($installs[1])->not->toBeEmpty();

    foreach ($installs[1] as $installed) {
        expect($installed)->toBe($version);
    }
});

it('test_readme_documents_icon_format_variant_and_sizes', function () {
    $readme = (string) file_get_contents(jetaxPackagePath('README.md'));

    expect($readme)->toContain('`[estilo:]nome`')
        ->toContain('regular:bell')
        ->toContain('brands:whatsapp')
        ->toContain('variant="solid|regular|brands"')
        ->toContain('`text-[12px]`')
        ->toContain('`text-[15px]`')
        ->toContain('`text-[18px]`')
        ->toContain('`text-[24px]`')
        ->toContain('font-size:<m>px')
        ->not->toMatch('/material/i');
});
