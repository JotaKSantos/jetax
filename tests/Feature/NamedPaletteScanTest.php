<?php

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Paleta nomeada nos componentes da F1 (SPEC jetax-f1-alinhamento-v2, RNF-03)
|--------------------------------------------------------------------------
|
| Nos componentes tocados pela F1 (lista de RNF-03, com chip e button-group),
| nenhum `bg-white`, `*-slate-*`, `*-gray-*`, `bg-red-50`, `bg-green-50` nem
| `bg-amber-50`. Linha de base da T05: 65 ocorrências.
|
| `text-white` só vale sobre fundo `*-solid`, da família `primary` (inclui
| `secondary`/`secondary-container`, que T-1 deriva de `--pri`) ou gradiente.
| Duas exceções declaradas: `bg-success` (botão verde do mockup, fora do gate
| de contraste em ContrastTest) e o `bg-[{$value}]` da cor `custom` do botão,
| cujo token é escolhido pelo consumidor (RF-14).
|
*/

dataset('componentes_rnf03', [
    'alert', 'badge', 'button', 'card', 'checkbox', 'currency', 'dialog', 'dropdown',
    'dropdown-item', 'editor', 'form-group', 'input', 'modal', 'page-header', 'pagination',
    'popover', 'select', 'stats-card', 'table', 'tag-input', 'textarea', 'time',
    'timeline-item', 'toggle', 'topbar', 'chip', 'button-group',
]);

/**
 * Fontes do componente: a view e, quando existe, a classe em src/View/Components.
 *
 * @return array<string, string> caminho relativo => conteúdo
 */
function namedPaletteSources(string $component): array
{
    $root = dirname(__DIR__, 2);
    $paths = [
        "resources/views/components/{$component}.blade.php",
        'src/View/Components/'.Str::studly($component).'.php',
    ];

    $sources = [];

    foreach ($paths as $path) {
        if (is_file("{$root}/{$path}")) {
            $sources[$path] = file_get_contents("{$root}/{$path}");
        }
    }

    return $sources;
}

it('test_component_has_no_named_palette_literal', function (string $component) {
    $sources = namedPaletteSources($component);

    expect($sources)->toHaveKey("resources/views/components/{$component}.blade.php");

    $found = [];

    foreach ($sources as $path => $content) {
        preg_match_all('/bg-white|[a-z]+-(?:slate|gray)-\d+|bg-(?:red|green|amber)-50(?!\d)/', $content, $matches);

        foreach ($matches[0] as $match) {
            $found[] = "{$path}: {$match}";
        }
    }

    expect($found)->toBe([]);
})->with('componentes_rnf03');

it('test_text_white_only_over_solid_primary_or_gradient', function (string $component) {
    $allowedBackground = '/(?<![\w-])(?:[a-z-]+:)*(?:bg-[a-z-]+-solid|bg-(?:primary|primary-container|primary-deep|secondary|secondary-container)(?:\/\d+)?|bg-success|bg-\[\{\$value\}\]|bg-linear-to-\w+|bg-gradient-to-\w+)(?![\w-])/';
    $offending = [];

    foreach (namedPaletteSources($component) as $path => $content) {
        preg_match_all('/"[^"\n]*"|\'[^\'\n]*\'/', $content, $strings);

        foreach ($strings[0] as $string) {
            if (preg_match('/(?<![\w-])text-white(?![\w-])/', $string) && ! preg_match($allowedBackground, $string)) {
                $offending[] = "{$path}: {$string}";
            }
        }
    }

    expect($offending)->toBe([]);
})->with('componentes_rnf03');

it('test_text_white_rule_rejects_non_solid_background', function () {
    $allowedBackground = '/(?<![\w-])(?:[a-z-]+:)*(?:bg-[a-z-]+-solid|bg-(?:primary|primary-container|primary-deep|secondary|secondary-container)(?:\/\d+)?|bg-success|bg-\[\{\$value\}\]|bg-linear-to-\w+|bg-gradient-to-\w+)(?![\w-])/';

    expect(preg_match($allowedBackground, 'bg-danger-solid text-white'))->toBe(1)
        ->and(preg_match($allowedBackground, 'bg-primary/40 text-white/70'))->toBe(1)
        ->and(preg_match($allowedBackground, 'bg-linear-to-br from-primary-container to-primary-deep text-white'))->toBe(1)
        ->and(preg_match($allowedBackground, 'bg-on-surface text-white'))->toBe(0)
        ->and(preg_match($allowedBackground, 'bg-warning text-white'))->toBe(0)
        ->and(preg_match($allowedBackground, 'bg-info text-white'))->toBe(0);
});

it('test_button_solid_colors_keep_white_text_over_solid_tokens', function (string $color, string $background) {
    $html = (string) $this->blade('<x-jetax-button color="'.$color.'">Ok</x-jetax-button>');

    expect(tagClass(htmlTag($html, 'button')))->toContain($background)->toContain('text-white');
})->with([
    'info' => ['info', 'bg-secondary-container'],
    'warning' => ['warning', 'bg-warning-solid'],
    'danger' => ['danger', 'bg-danger-solid'],
]);

it('test_dark_button_uses_surface_text_instead_of_white', function () {
    $class = tagClass(htmlTag((string) $this->blade('<x-jetax-button color="dark">Ok</x-jetax-button>'), 'button'));

    expect($class)->toContain('bg-on-surface')->toContain('text-surface')->not->toContain('text-white');
});
