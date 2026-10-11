<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Jetax\DesignSystem\DataTable\BulkActions\BulkAction;

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

/**
 * Casos de raiz única: um por componente de escopo `matriz` (SPEC
 * jetax-f3-matriz-forma, RF-07; 67 componentes, com os 4 `data-table.*`).
 * A chave é o nome da tag sem o prefixo `x-jetax-`; o segundo item fixa o
 * destino do `class` nas exceções da F1, ou `null` para o primeiro elemento.
 *
 * @return array<string, array{0: string, 1: array{0: string, 1: string}|null}>
 */
function classRootCases(): array
{
    return [
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
        'accordion-item' => ['<x-jetax-accordion-item title="Seção" class="probe-xyz">Corpo</x-jetax-accordion-item>', null],
        'accordion' => ['<x-jetax-accordion class="probe-xyz">Itens</x-jetax-accordion>', null],
        'activity-feed-item' => ['<x-jetax-activity-feed-item description="Evento" class="probe-xyz" />', null],
        'activity-feed' => ['<x-jetax-activity-feed class="probe-xyz">Itens</x-jetax-activity-feed>', null],
        'avatar' => ['<x-jetax-avatar name="Ana Lima" class="probe-xyz" />', null],
        'back-to-top' => ['<x-jetax-back-to-top class="probe-xyz" />', null],
        'breadcrumbs' => ['<x-jetax-breadcrumbs :items="$breadcrumbs" class="probe-xyz" />', null],
        'carousel-item' => ['<x-jetax-carousel-item class="probe-xyz">Slide</x-jetax-carousel-item>', null],
        'carousel' => ['<x-jetax-carousel class="probe-xyz">Slides</x-jetax-carousel>', null],
        'clipboard' => ['<x-jetax-clipboard text="abc" class="probe-xyz" />', null],
        'collapse' => ['<x-jetax-collapse class="probe-xyz">Conteúdo</x-jetax-collapse>', null],
        'color' => ['<x-jetax-color class="probe-xyz" />', null],
        'dark-mode-toggle' => ['<x-jetax::dark-mode-toggle class="probe-xyz" />', null],
        'data-table.bulk-bar' => ['<x-jetax::data-table.bulk-bar :bulk-actions="$bulkActions" :selected-count="2" class="probe-xyz" />', null],
        'data-table.empty' => ['<x-jetax::data-table.empty class="probe-xyz" />', null],
        'data-table.index' => ['<x-jetax::data-table.index :rows="$paginator" class="probe-xyz" />', null],
        'data-table.toolbar' => ['<x-jetax::data-table.toolbar class="probe-xyz" />', null],
        'detail-summary' => ['<x-jetax-detail-summary :items="$details" class="probe-xyz" />', null],
        'dismissable' => ['<x-jetax-dismissable class="probe-xyz">Conteúdo</x-jetax-dismissable>', null],
        'dropdown-separator' => ['<x-jetax-dropdown-separator class="probe-xyz" />', null],
        'empty-state' => ['<x-jetax-empty-state title="Nada por aqui" class="probe-xyz" />', null],
        'icon' => ['<x-jetax-icon name="paw" class="probe-xyz" />', null],
        'list-group-item' => ['<x-jetax-list-group-item title="Item" class="probe-xyz" />', null],
        'list-group' => ['<x-jetax-list-group class="probe-xyz">Itens</x-jetax-list-group>', null],
        'offcanvas' => ['<x-jetax-offcanvas id="oc1" title="Título" class="probe-xyz">Corpo</x-jetax-offcanvas>', null],
        'pin' => ['<x-jetax-pin class="probe-xyz" />', null],
        'progress' => ['<x-jetax-progress :value="40" class="probe-xyz" />', null],
        'radio' => ['<x-jetax-radio label="Sim" name="opcao" value="1" class="probe-xyz" />', null],
        'range' => ['<x-jetax-range class="probe-xyz" />', null],
        'rating' => ['<x-jetax-rating :value="3" class="probe-xyz" />', null],
        'sidebar' => ['<x-jetax::sidebar title="Menu" class="probe-xyz">Itens</x-jetax::sidebar>', null],
        'skeleton' => ['<x-jetax-skeleton class="probe-xyz" />', null],
        'spinner' => ['<x-jetax-spinner class="probe-xyz" />', null],
        'step-item' => ['<x-jetax-step-item label="Passo" class="probe-xyz" />', null],
        'step' => ['<x-jetax-step class="probe-xyz">Passos</x-jetax-step>', null],
        'tabs' => ['<x-jetax-tabs :tabs="$tabs" class="probe-xyz" />', null],
        'timeline' => ['<x-jetax-timeline class="probe-xyz">Eventos</x-jetax-timeline>', null],
        'toast-container' => ['<x-jetax-toast-container class="probe-xyz" />', null],
        'tooltip' => ['<x-jetax-tooltip content="Dica" class="probe-xyz">Alvo</x-jetax-tooltip>', null],
        'upload' => ['<x-jetax-upload class="probe-xyz" />', null],
    ];
}

dataset('raizes_rnf04', classRootCases());

/*
| Páginas fora da guarda (SPEC jetax-f3-matriz-forma v1.1, Q-11): layout,
| auth-layout, docs-layout e docs-preview-section. Todo outro template em
| resources/views/components tem chave no dataset raizes_rnf04.
*/
const CLASS_ROOT_EXCLUDED_PAGES = ['layout', 'auth-layout', 'docs-layout', 'docs-preview-section'];

/**
 * Componentes em disco, no formato da tag (`data-table/index` vira `data-table.index`).
 *
 * @return array<int, string>
 */
function classRootTemplatesOnDisk(): array
{
    $directory = dirname(__DIR__, 2).'/resources/views/components';
    $components = [];

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS));

    foreach ($files as $file) {
        if (! str_ends_with($file->getFilename(), '.blade.php')) {
            continue;
        }

        $relative = substr($file->getPathname(), strlen($directory) + 1, -strlen('.blade.php'));
        $components[] = str_replace(DIRECTORY_SEPARATOR, '.', $relative);
    }

    sort($components);

    return $components;
}

it('test_consumer_class_lands_on_single_class_root', function (string $template, ?array $classRoot) {
    $paginator = new LengthAwarePaginator(collect(range(1, 10)), 50, 10, 1);
    $html = (string) $this->blade($template, [
        'paginator' => $paginator,
        'bulkActions' => [BulkAction::make('publish', 'Publicar')],
        'breadcrumbs' => [['label' => 'Início', 'url' => '/'], ['label' => 'Clientes']],
        'details' => [['label' => 'Cliente', 'value' => 'Ana']],
        'tabs' => [['name' => 'geral', 'label' => 'Geral'], ['name' => 'conta', 'label' => 'Conta']],
    ]);
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

it('test_dataset_covers_every_component_template_except_pages', function () {
    $onDisk = classRootTemplatesOnDisk();

    foreach (CLASS_ROOT_EXCLUDED_PAGES as $page) {
        expect($onDisk)->toContain($page);
    }

    $expected = array_values(array_diff($onDisk, CLASS_ROOT_EXCLUDED_PAGES));
    $keys = array_keys(classRootCases());
    sort($keys);

    expect($expected)->toHaveCount(67)
        ->and(array_values(array_diff($expected, $keys)))->toBe([])
        ->and($keys)->toBe($expected);
});
