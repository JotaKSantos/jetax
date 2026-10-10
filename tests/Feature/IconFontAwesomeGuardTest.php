<?php

use Jetax\DesignSystem\Docs\ComponentRegistry;
use Jetax\DesignSystem\Support\FontAwesome;

/**
 * Guarda do sistema de ícones Font Awesome (SPEC jetax-f2, RF-06, RF-07, RF-09).
 *
 * Substitui a `IconSystemGuardTest` da F1: o pacote não guarda resquício de
 * Material, todo nome de ícone que ele define existe no manifesto (CT-02) no
 * estilo usado, e nenhum elemento de ícone recebe o nome por texto.
 */
const ICON_GUARD_ROOTS = ['resources', 'src', 'config'];

/**
 * Classes do Font Awesome que não nomeiam ícone (estilo, tamanho, animação, layout).
 */
const FA_UTILITY_CLASSES = [
    'fa-solid', 'fa-regular', 'fa-brands', 'fa-fw', 'fa-li', 'fa-ul', 'fa-border', 'fa-inverse',
    'fa-pull-left', 'fa-pull-right', 'fa-spin', 'fa-spin-pulse', 'fa-spin-reverse', 'fa-pulse',
    'fa-beat', 'fa-beat-fade', 'fa-bounce', 'fa-fade', 'fa-flip', 'fa-shake',
    'fa-flip-horizontal', 'fa-flip-vertical', 'fa-flip-both', 'fa-rotate-90', 'fa-rotate-180',
    'fa-rotate-270', 'fa-rotate-by', 'fa-stack', 'fa-stack-1x', 'fa-stack-2x', 'fa-sr-only',
    'fa-2xs', 'fa-xs', 'fa-sm', 'fa-lg', 'fa-xl', 'fa-2xl', 'fa-1x', 'fa-2x', 'fa-3x', 'fa-4x',
    'fa-5x', 'fa-6x', 'fa-7x', 'fa-8x', 'fa-9x', 'fa-10x',
];

/**
 * Tag de abertura com atributos entre aspas (aceita `>` dentro do valor).
 */
const OPENING_TAG_PATTERN = '/<([a-z][\w.:-]*)\b((?:[^>"\']|"[^"]*"|\'[^\']*\')*)>/i';

function iconGuardPath(string $path = ''): string
{
    return realpath(__DIR__.'/../..').($path === '' ? '' : '/'.$path);
}

/**
 * Arquivos de código do pacote, por caminho relativo.
 *
 * @return array<string, string>
 */
function iconGuardFiles(bool $withReadme = false): array
{
    $files = [];

    foreach (ICON_GUARD_ROOTS as $root) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(iconGuardPath($root), FilesystemIterator::SKIP_DOTS));

        foreach ($iterator as $file) {
            $relative = substr($file->getPathname(), strlen(iconGuardPath()) + 1);
            $files[$relative] = (string) file_get_contents($file->getPathname());
        }
    }

    if ($withReadme) {
        $files['README.md'] = (string) file_get_contents(iconGuardPath('README.md'));
    }

    ksort($files);

    return $files;
}

/**
 * Templates do pacote: views Blade e templates embutidos nas classes PHP.
 *
 * @return array<string, string>
 */
function iconGuardTemplates(): array
{
    return array_filter(
        iconGuardFiles(),
        fn (string $source, string $path): bool => str_starts_with($path, 'resources/views/') || (str_starts_with($path, 'src/') && str_contains($source, '<x-jetax')),
        ARRAY_FILTER_USE_BOTH,
    );
}

/**
 * Tags de abertura que são elemento de ícone FA: `<x-jetax-icon>` ou tag com classe `fa-`.
 *
 * @return array<int, array{file: string, tag: string}>
 */
function fontAwesomeElements(): array
{
    $elements = [];

    foreach (iconGuardTemplates() as $path => $source) {
        preg_match_all(OPENING_TAG_PATTERN, $source, $tags, PREG_SET_ORDER);

        foreach ($tags as [$tag, $name]) {
            if (strtolower($name) === 'x-jetax-icon' || preg_match('/\bfa-(solid|regular|brands)\b|[\'"\s]fa-[a-z]/', $tag)) {
                $elements[] = ['file' => $path, 'tag' => $tag];
            }
        }
    }

    return $elements;
}

/**
 * Todo nome de ícone que o pacote define por conta própria (RF-06), com o estilo usado.
 *
 * @return array<string, array<int, array{value: string, variant: ?string, source: string}>>
 */
function packageIconLiterals(): array
{
    $found = [
        'template-name' => [],
        'template-class' => [],
        'icon-attribute' => [],
        'icon-expression' => [],
        'array-key' => [],
        'icon-method-call' => [],
        'icon-default' => [],
        'icon-method-return' => [],
        'component-registry' => [],
    ];

    $add = function (string $kind, string $value, string $source, ?string $variant = null) use (&$found): void {
        $found[$kind][] = ['value' => $value, 'variant' => $variant, 'source' => $source];
    };

    foreach (iconGuardFiles() as $path => $raw) {
        $source = str_replace(['&lt;', '&gt;', '&quot;'], ['<', '>', '"'], $raw);

        preg_match_all(OPENING_TAG_PATTERN, $source, $tags, PREG_SET_ORDER);

        foreach ($tags as [$tag, $tagName]) {
            $isIcon = strtolower($tagName) === 'x-jetax-icon';
            preg_match('/(?<![:\w-])variant="([^"]*)"/', $tag, $variant);
            $variant = $variant[1] ?? null;

            if ($isIcon && preg_match('/(?<![:\w-])name="([^"{$]+)"/', $tag, $name)) {
                $add('template-name', $name[1], "{$path} {$tag}", $variant);
            }

            if (str_starts_with(strtolower($tagName), 'x-jetax') && preg_match('/(?<![:\w-])icon="([^"{$]+)"/', $tag, $icon)) {
                $add('icon-attribute', $icon[1], "{$path} {$tag}");
            }

            if (preg_match_all('/(?<![\w-])(?:x-bind)?:(?:name|icon)="([^"]*)"/', $tag, $expressions) && ($isIcon || str_starts_with(strtolower($tagName), 'x-jetax'))) {
                foreach ($expressions[1] as $expression) {
                    preg_match_all('/(?<!\[)\'([a-z0-9]+(?:-[a-z0-9]+)*(?::[a-z0-9]+(?:-[a-z0-9]+)*)?)\'(?!\])/', $expression, $literals);

                    foreach ($literals[1] as $literal) {
                        $add('icon-expression', $literal, "{$path} {$tag}", $isIcon ? $variant : null);
                    }
                }
            }

            if (preg_match('/\bfa-(solid|regular|brands)\b/', $tag, $style)) {
                preg_match_all('/(?<![\w-])fa-([a-z0-9_-]*[a-z0-9_])(?![\w{$-])/i', $tag, $classes);

                foreach (array_unique($classes[0]) as $index => $class) {
                    if (! in_array($class, FA_UTILITY_CLASSES, true)) {
                        $add('template-class', $style[1].':'.$classes[1][$index], "{$path} {$tag}");
                    }
                }
            }
        }

        preg_match_all('/[\'"]icon[\'"]\s*=>\s*[\'"]([^\'"]+)[\'"]/', $source, $arrayIcons);

        foreach ($arrayIcons[1] as $value) {
            $add('array-key', $value, $path);
        }

        preg_match_all('/->icon\(\s*[\'"]([^\'"]+)[\'"]\s*\)/', $source, $calls);

        foreach ($calls[1] as $value) {
            $add('icon-method-call', $value, $path);
        }

        if (str_starts_with($path, 'src/')) {
            preg_match_all('/\$icon\s*=\s*\'([^\']+)\'/', $source, $defaults);

            foreach ($defaults[1] as $value) {
                $add('icon-default', $value, $path);
            }

            preg_match_all('/function\s+(\w*[iI]con\w*)\s*\(\s*\)\s*:\s*string\s*\{(.*?)\n    \}/s', $source, $methods, PREG_SET_ORDER);

            foreach ($methods as [, $method, $body]) {
                if (! str_contains($body, 'match')) {
                    continue;
                }

                preg_match_all('/=>\s*\'([^\']+)\'/', $body, $returns);

                foreach ($returns[1] as $value) {
                    if (! str_starts_with($value, 'text-') && ! str_starts_with($value, 'bg-') && ! str_contains($value, ' ')) {
                        $add('icon-method-return', $value, "{$path} {$method}()");
                    }
                }
            }
        }
    }

    foreach (ComponentRegistry::componentIcons() as $slug => $value) {
        $add('component-registry', $value, "ComponentRegistry::componentIcons() {$slug}");
    }

    return $found;
}

/**
 * Resolve `[estilo:]nome` (com o `variant` do elemento) para estilo e nome.
 *
 * @return array{style: string, name: string}|null
 */
function resolveIconLiteral(string $value, ?string $variant): ?array
{
    $name = $value;
    $style = $variant ?? FontAwesome::DEFAULT_STYLE;

    if (str_contains($value, ':')) {
        [$style, $name] = explode(':', $value, 2);

        if ($variant !== null && $variant !== $style) {
            return null;
        }
    }

    return in_array($style, FontAwesome::STYLES, true) ? ['style' => $style, 'name' => $name] : null;
}

it('test_package_has_no_material_residue', function () {
    $residues = [];

    foreach (iconGuardFiles(withReadme: true) as $path => $source) {
        foreach (explode("\n", $source) as $index => $line) {
            if (preg_match('/material-symbols|material symbols|material\+symbols|font-variation-settings/i', $line)) {
                $residues[] = $path.':'.($index + 1);
            }
        }
    }

    expect($residues)->toBe([]);
});

it('test_guard_scans_every_code_root_and_the_readme', function () {
    $paths = array_keys(iconGuardFiles(withReadme: true));

    expect($paths)->toContain('README.md')
        ->toContain('config/jetax.php')
        ->toContain('src/View/Components/Icon.php')
        ->toContain('resources/views/components/icon.blade.php')
        ->toContain('resources/css/jetax.css')
        ->not->toContain('CHANGELOG.md')
        ->not->toContain('UPGRADE.md');
});

it('test_extraction_finds_every_kind_of_icon_literal', function () {
    $literals = packageIconLiterals();
    $minimums = [
        'template-name' => 115,
        'template-class' => 6,
        'icon-attribute' => 130,
        'icon-expression' => 1,
        'array-key' => 25,
        'icon-method-call' => 5,
        'icon-default' => 1,
        'icon-method-return' => 7,
        'component-registry' => 56,
    ];

    foreach ($minimums as $kind => $minimum) {
        expect(count($literals[$kind]))->toBeGreaterThanOrEqual($minimum, $kind);
    }

    expect(array_sum(array_map('count', $literals)))->toBeGreaterThanOrEqual(360);
});

it('test_extraction_reads_known_literals', function () {
    $values = array_column(array_merge(...array_values(packageIconLiterals())), 'value');

    expect($values)
        ->toContain('ellipsis-vertical')
        ->toContain('solid:circle-check')
        ->toContain('solid:eye-slash')
        ->toContain('arrow-trend-up')
        ->toContain('triangle-exclamation')
        ->toContain('circle-plus')
        ->toContain('inbox')
        ->toContain('cubes')
        ->toContain('right-from-bracket')
        ->toContain('ban');
});

it('test_every_package_icon_name_exists_in_manifest', function () {
    $invalid = [];

    foreach (packageIconLiterals() as $kind => $literals) {
        foreach ($literals as $literal) {
            $resolved = resolveIconLiteral($literal['value'], $literal['variant']);

            if ($resolved === null || ! FontAwesome::has($resolved['name'], $resolved['style'])) {
                $invalid[] = "{$kind}: {$literal['value']} ({$literal['source']})";
            }
        }
    }

    expect($invalid)->toBe([]);
});

it('test_resolution_rejects_names_outside_manifest', function () {
    expect(resolveIconLiteral('paw', null))->toBe(['style' => 'solid', 'name' => 'paw'])
        ->and(resolveIconLiteral('regular:bell', null))->toBe(['style' => 'regular', 'name' => 'bell'])
        ->and(resolveIconLiteral('bell', 'regular'))->toBe(['style' => 'regular', 'name' => 'bell'])
        ->and(resolveIconLiteral('regular:bell', 'solid'))->toBeNull()
        ->and(resolveIconLiteral('outlined:paw', null))->toBeNull()
        ->and(FontAwesome::has('whatsapp', 'solid'))->toBeFalse()
        ->and(FontAwesome::has('expand_more', 'solid'))->toBeFalse();
});

it('test_no_font_awesome_element_uses_x_text_or_x_html', function () {
    $elements = fontAwesomeElements();
    $offenders = array_filter($elements, fn (array $element): bool => (bool) preg_match('/\sx-(text|html)\b/', $element['tag']));

    expect(count($elements))->toBeGreaterThanOrEqual(150)
        ->and(array_map(fn (array $element): string => "{$element['file']}: {$element['tag']}", $offenders))->toBe([]);
});

it('test_no_font_awesome_element_has_inline_font_size', function () {
    $offenders = array_filter(
        fontAwesomeElements(),
        fn (array $element): bool => $element['file'] !== 'resources/views/components/icon.blade.php'
            && (bool) preg_match('/(?<![\w-])(?:x-bind)?:?style="[^"]*font-size/i', $element['tag']),
    );

    expect(array_map(fn (array $element): string => "{$element['file']}: {$element['tag']}", $offenders))->toBe([]);
});

it('test_icon_component_is_the_only_inline_font_size_path', function () {
    $source = (string) file_get_contents(iconGuardPath('resources/views/components/icon.blade.php'));

    expect($source)->toContain('$inlineFontSize()')
        ->not->toContain('style="font-size');
});

it('test_f1_material_guard_tests_are_gone', function () {
    $forbidden = ['test_page_header_icon_uses_'.'material_symbols', 'test_package_never_references_'.'font_awesome'];
    $found = [];

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(iconGuardPath('tests'), FilesystemIterator::SKIP_DOTS));

    foreach ($iterator as $file) {
        $source = (string) file_get_contents($file->getPathname());

        foreach ($forbidden as $name) {
            if (str_contains($source, $name)) {
                $found[] = $file->getFilename().': '.$name;
            }
        }
    }

    expect($found)->toBe([])
        ->and(file_exists(iconGuardPath('tests/Feature/IconSystemGuardTest.php')))->toBeFalse();
});
