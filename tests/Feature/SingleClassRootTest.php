<?php

use Illuminate\Pagination\LengthAwarePaginator;

/*
|--------------------------------------------------------------------------
| Raiz única de `class` (SPEC jetax-f1-alinhamento-v2, RNF-04)
|--------------------------------------------------------------------------
|
| Cada componente da lista de RNF-03 (com chip e button-group), renderizado
| com `class="probe-xyz"`, emite exatamente um atributo `class` no elemento
| raiz, contendo `probe-xyz`; a classe não se repete em nenhum outro elemento
| e nenhuma tag do HTML sai com dois atributos `class`.
|
| Dropdown e popover vão em várias linhas: com o `<x-slot:trigger>` colado na
| tag de abertura, o Blade deixa um output buffer aberto e o teste sai risky.
|
| Elemento raiz = o primeiro elemento do HTML renderizado. Três grupos têm o
| destino do `class` fixado por requisito do próprio SPEC, e para eles a raiz
| de `class` é esse elemento:
|   - input, select, textarea e time: o controle (RF-17, JETAX-017; o time segue
|     a mesma família de campos);
|   - checkbox: o `<input type="checkbox">` (RF-18, JETAX-020);
|   - modal: o painel com `x-trap.noscroll` (RF-25 e overrides-api.md, T16).
|
*/

/**
 * Tags de abertura do HTML, com o nome e a string de atributos. Os valores entre
 * aspas podem conter `>` (x-data, @click), por isso o recorte é por atributo.
 *
 * @return array<int, array{name: string, attributes: string, tag: string}>
 */
function classRootOpeningTags(string $html): array
{
    $attribute = '\s+[^\s=>\/"\']+(?:\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>"\']+))?';

    preg_match_all('/<([a-zA-Z][\w-]*)((?:'.$attribute.')*)\s*\/?>/s', $html, $matches, PREG_SET_ORDER);

    return array_map(fn (array $match): array => [
        'name' => strtolower($match[1]),
        'attributes' => $match[2],
        'tag' => $match[0],
    ], $matches);
}

/**
 * Valores dos atributos `class` literais da tag (ignora `:class` e `x-bind:class`).
 *
 * @return array<int, string>
 */
function classRootClassValues(string $attributes): array
{
    preg_match_all('/(?<![\w:.@-])class\s*=\s*("([^"]*)"|\'([^\']*)\')/', $attributes, $matches, PREG_SET_ORDER);

    return array_map(fn (array $match): string => ($match[2] ?? '') !== '' ? $match[2] : ($match[3] ?? ''), $matches);
}

dataset('raizes_rnf04', [
    'alert' => ['<x-jetax-alert message="ok" class="probe-xyz" />', null],
    'badge' => ['<x-jetax-badge class="probe-xyz">A</x-jetax-badge>', null],
    'button' => ['<x-jetax-button class="probe-xyz">A</x-jetax-button>', null],
    'card' => ['<x-jetax-card class="probe-xyz">A</x-jetax-card>', null],
    'checkbox' => ['<x-jetax-checkbox name="aceite" label="Aceite" class="probe-xyz" />', ['input', 'type="checkbox"']],
    'currency' => ['<x-jetax-currency name="valor" label="Valor" class="probe-xyz" />', null],
    'dialog' => ['<x-jetax-dialog id="d1" title="Título" class="probe-xyz" />', null],
    'dropdown' => ["<x-jetax-dropdown class=\"probe-xyz\">\n<x-slot:trigger>Abrir</x-slot:trigger>\nItem\n</x-jetax-dropdown>", null],
    'dropdown-item' => ['<x-jetax-dropdown-item class="probe-xyz">Item</x-jetax-dropdown-item>', null],
    'editor' => ['<x-jetax-editor name="texto" class="probe-xyz" />', null],
    'form-group' => ['<x-jetax-form-group label="Nome" class="probe-xyz">Campo</x-jetax-form-group>', null],
    'input' => ['<x-jetax-input name="nome" label="Nome" class="probe-xyz" />', ['input', 'name="nome"']],
    'modal' => ['<x-jetax-modal id="m1" class="probe-xyz">Corpo</x-jetax-modal>', ['div', 'x-trap.noscroll']],
    'page-header' => ['<x-jetax-page-header title="Título" class="probe-xyz" />', null],
    'pagination' => ['<x-jetax-pagination :paginator="$paginator" class="probe-xyz" />', null],
    'popover' => ["<x-jetax-popover class=\"probe-xyz\">\n<x-slot:trigger>Abrir</x-slot:trigger>\nConteúdo\n</x-jetax-popover>", null],
    'select' => ['<x-jetax-select name="opcao" label="Opção" :options="[\'a\' => \'A\']" class="probe-xyz" />', ['select', 'name="opcao"']],
    'stats-card' => ['<x-jetax-stats-card label="Total" value="10" class="probe-xyz" />', null],
    'table' => ['<x-jetax-table class="probe-xyz">Linhas</x-jetax-table>', null],
    'tag-input' => ['<x-jetax-tag-input name="tags" class="probe-xyz" />', null],
    'textarea' => ['<x-jetax-textarea name="obs" label="Obs" class="probe-xyz" />', ['textarea', 'name="obs"']],
    'time' => ['<x-jetax-time name="hora" label="Hora" class="probe-xyz" />', ['input', 'type="time"']],
    'timeline-item' => ['<x-jetax-timeline-item title="Evento" class="probe-xyz" />', null],
    'toggle' => ['<x-jetax-toggle name="ativo" label="Ativo" class="probe-xyz" />', null],
    'topbar' => ['<x-jetax-topbar class="probe-xyz" />', null],
    'chip' => ['<x-jetax-chip class="probe-xyz">Tag</x-jetax-chip>', null],
    'button-group' => ['<x-jetax-button-group class="probe-xyz"><x-jetax-button>Salvar</x-jetax-button></x-jetax-button-group>', null],
]);

it('test_consumer_class_lands_on_single_class_root', function (string $template, ?array $classRoot) {
    $paginator = new LengthAwarePaginator(collect(range(1, 10)), 50, 10, 1);
    $html = (string) $this->blade($template, ['paginator' => $paginator]);
    $tags = classRootOpeningTags($html);

    expect($tags)->not->toBeEmpty();

    if ($classRoot === null) {
        $root = $tags[0];
    } else {
        [$name, $containing] = $classRoot;
        $candidates = array_values(array_filter(
            $tags,
            fn (array $tag): bool => $tag['name'] === $name && str_contains($tag['attributes'], $containing),
        ));

        expect($candidates)->not->toBeEmpty();
        $root = $candidates[0];
    }

    $rootClasses = classRootClassValues($root['attributes']);

    expect($rootClasses)->toHaveCount(1)
        ->and(preg_split('/\s+/', trim($rootClasses[0])))->toContain('probe-xyz')
        ->and(substr_count($html, 'probe-xyz'))->toBe(1);

    foreach ($tags as $tag) {
        expect(count(classRootClassValues($tag['attributes'])))->toBeLessThanOrEqual(1, $tag['tag']);
    }
})->with('raizes_rnf04');

it('test_tag_parser_counts_duplicate_class_attributes', function () {
    $tags = classRootOpeningTags('<div x-data="{ a: 1 > 0 }" class="a" :class="b" class="c"><span class="d">x</span></div>');

    expect($tags)->toHaveCount(2)
        ->and(classRootClassValues($tags[0]['attributes']))->toBe(['a', 'c'])
        ->and(classRootClassValues($tags[1]['attributes']))->toBe(['d']);
});
