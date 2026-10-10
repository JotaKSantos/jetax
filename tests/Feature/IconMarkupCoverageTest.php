<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Blade;
use Jetax\DesignSystem\DataTable\BulkActions\BulkAction;
use Jetax\DesignSystem\DataTable\Columns\ActionsColumn;
use Livewire\Livewire;
use Tests\Fixtures\DataTables\PostsTable;
use Tests\Fixtures\Models\Post;

/**
 * Cobertura da marcação FA nos componentes que exibem ícone (SPEC jetax-f2, RF-05, CT-03).
 *
 * A lista é a fechada da baseline (seção "Componentes que exibem ícone" de
 * `evidence/pacote-inventario.md`), copiada aqui sem ler `.spec/`.
 */
const ICON_COMPONENTS = [
    'DataTable/Columns/ActionsColumn',
    'accordion-item',
    'activity-feed',
    'activity-feed-item',
    'alert',
    'auth-layout',
    'back-to-top',
    'breadcrumbs',
    'button',
    'carousel',
    'chip',
    'clipboard',
    'collapse',
    'dark-mode-toggle',
    'data-table/bulk-bar',
    'data-table/empty',
    'data-table/index',
    'dialog',
    'dismissable',
    'docs-layout',
    'docs-preview-section',
    'dropdown-item',
    'editor',
    'empty-state',
    'icon',
    'input',
    'layout',
    'list-group-item',
    'modal',
    'offcanvas',
    'page-header',
    'pagination',
    'rating',
    'select',
    'sidebar',
    'stats-card',
    'step-item',
    'table',
    'timeline-item',
    'toast-container',
    'topbar',
    'upload',
];

/**
 * Renderiza o componente da lista com ícone: o `icon` informado quando o
 * componente aceita, ou o padrão dele.
 */
function renderIconComponent(string $component): string
{
    return match ($component) {
        'DataTable/Columns/ActionsColumn' => (function (): string {
            test()->setUpPostsTable();
            $post = Post::create(['title' => 'Ícone', 'status' => 'draft']);

            return (string) ActionsColumn::make('actions', '')
                ->actions([
                    ['key' => 'edit', 'label' => 'Editar', 'icon' => 'pen', 'href' => '#'],
                    ['key' => 'view', 'label' => 'Ver', 'icon' => 'eye', 'href' => '#'],
                    ['key' => 'delete', 'label' => 'Excluir', 'icon' => 'regular:trash-can', 'href' => '#'],
                ])
                ->collapseAfter(1)
                ->render($post);
        })(),
        'accordion-item' => Blade::render('<x-jetax-accordion><x-jetax-accordion-item title="Item">Conteúdo</x-jetax-accordion-item></x-jetax-accordion>'),
        'activity-feed' => Blade::render('<x-jetax-activity-feed :has-more="true"><x-jetax-activity-feed-item description="Criado" /></x-jetax-activity-feed>'),
        'activity-feed-item' => Blade::render('<x-jetax-activity-feed-item type="created" description="Cliente criado" />'),
        'alert' => Blade::render('<x-jetax-alert icon="circle-info" dismissible>Mensagem</x-jetax-alert>'),
        'auth-layout' => Blade::render('<x-jetax-auth-layout>Conteúdo</x-jetax-auth-layout>'),
        'back-to-top' => Blade::render('<x-jetax-back-to-top />'),
        'breadcrumbs' => Blade::render('<x-jetax-breadcrumbs :items="$items" />', ['items' => [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Clientes', 'url' => '/clientes'],
            ['label' => 'Detalhes'],
        ]]),
        'button' => Blade::render('<x-jetax-button icon="floppy-disk">Salvar</x-jetax-button>'),
        'carousel' => Blade::render('<x-jetax-carousel><x-jetax-carousel-item>Slide 1</x-jetax-carousel-item><x-jetax-carousel-item>Slide 2</x-jetax-carousel-item></x-jetax-carousel>'),
        'chip' => Blade::render('<x-jetax-chip label="Filtro" removable />'),
        'clipboard' => Blade::render('<x-jetax-clipboard text="abc" />'),
        'collapse' => Blade::render('<x-jetax-collapse><p>Conteúdo</p></x-jetax-collapse>'),
        'dark-mode-toggle' => Blade::render('<x-jetax::dark-mode-toggle />'),
        'data-table/bulk-bar' => Blade::render(
            "@include('jetax::components.data-table.bulk-bar', ['bulkActions' => \$actions, 'selectedCount' => 2])",
            ['actions' => [BulkAction::make('publish', 'Publicar')->icon('circle-check')]]
        ),
        'data-table/empty' => Blade::render("@include('jetax::components.data-table.empty', ['title' => 'Vazio'])"),
        'data-table/index' => (function (): string {
            test()->setUpPostsTable();

            return Livewire::test(PostsTable::class)->html();
        })(),
        'dialog' => Blade::render('<x-jetax-dialog id="dlg" title="Excluir" message="Tem certeza?" variant="danger" />'),
        'dismissable' => Blade::render('<x-jetax-dismissable>Conteúdo</x-jetax-dismissable>'),
        'docs-layout' => Blade::render('<x-jetax-docs-layout>Conteúdo</x-jetax-docs-layout>'),
        'docs-preview-section' => Blade::render('<x-jetax-docs-preview-section title="Exemplo" code="&lt;x-jetax-icon name=&quot;paw&quot; /&gt;"><x-jetax-icon name="paw" /></x-jetax-docs-preview-section>'),
        'dropdown-item' => Blade::render('<x-jetax-dropdown-item icon="pen" href="#">Editar</x-jetax-dropdown-item>'),
        'editor' => Blade::render('<x-jetax-editor />'),
        'empty-state' => Blade::render('<x-jetax-empty-state title="Nada por aqui" />'),
        'icon' => Blade::render('<x-jetax-icon name="paw" />'),
        'input' => Blade::render('<x-jetax-input name="busca" icon="magnifying-glass" />'),
        'layout' => Blade::render('<x-jetax-layout>Conteúdo</x-jetax-layout>'),
        'list-group-item' => Blade::render('<x-jetax-list-group-item title="Item" icon="user" />'),
        'modal' => Blade::render('<x-jetax-modal id="m1" :high-risk="true">Corpo</x-jetax-modal>'),
        'offcanvas' => Blade::render('<x-jetax-offcanvas id="oc1" title="Título">Corpo</x-jetax-offcanvas>'),
        'page-header' => Blade::render('<x-jetax-page-header title="Clientes" icon="users" />'),
        'pagination' => Blade::render('<x-jetax-pagination :paginator="$paginator" />', ['paginator' => new LengthAwarePaginator(
            items: collect(range(1, 10)),
            total: 50,
            perPage: 10,
            currentPage: 2,
        )]),
        'rating' => Blade::render('<x-jetax-rating :value="3" />'),
        'select' => Blade::render('<x-jetax-select name="status" :options="[\'a\' => \'A\']" />'),
        'sidebar' => (function (): string {
            config()->set('jetax.navigation.main', [['label' => 'Clientes', 'icon' => 'users', 'route' => 'clients.*']]);

            return Blade::render('<x-jetax::sidebar title="App" />');
        })(),
        'stats-card' => Blade::render('<x-jetax-stats-card label="Receita" value="R$ 10" icon="dollar-sign" trend="up" trend-value="5%" />'),
        'step-item' => Blade::render('<x-jetax-step :current="3"><x-jetax-step-item :step="1" label="Feito" /></x-jetax-step>'),
        'table' => Blade::render('<x-jetax-table :columns="$columns" :rows="$rows" />', [
            'columns' => [['key' => 'name', 'label' => 'Nome', 'sortable' => true]],
            'rows' => [['name' => 'João']],
        ]),
        'timeline-item' => Blade::render('<x-jetax-timeline><x-jetax-timeline-item title="Evento" icon="calendar" /></x-jetax-timeline>'),
        'toast-container' => Blade::render('<x-jetax-toast-container />'),
        'topbar' => Blade::render('<x-jetax-topbar title="Agenda" />'),
        'upload' => Blade::render('<x-jetax-upload />'),
    };
}

it('test_component_list_matches_baseline_inventory', function () {
    expect(ICON_COMPONENTS)->toHaveCount(42)
        ->and(array_unique(ICON_COMPONENTS))->toHaveCount(42);

    foreach (ICON_COMPONENTS as $component) {
        if (str_contains($component, '/Columns/')) {
            expect(file_exists(__DIR__.'/../../src/'.$component.'.php'))->toBeTrue($component);

            continue;
        }

        expect(file_exists(__DIR__.'/../../resources/views/components/'.$component.'.blade.php'))->toBeTrue($component);
    }
});

it('test_component_renders_font_awesome_markup', function (string $component) {
    $html = renderIconComponent($component);

    expect($html)->toMatch('/class="[^"]*\bfa-(solid|regular|brands)\b/')
        ->toMatch('/\bfa-(?!solid\b|regular\b|brands\b)[a-z0-9]+(-[a-z0-9]+)*\b/')
        ->not->toContain('material-symbols')
        ->not->toContain('font-variation-settings');

    preg_match_all('/<i\b((?:[^>"\']|"[^"]*"|\'[^\']*\')*)>(.*?)<\/i>/s', $html, $glyphs, PREG_SET_ORDER);

    $faGlyphs = array_filter($glyphs, fn (array $glyph): bool => (bool) preg_match('/\bfa-(solid|regular|brands)\b/', $glyph[1]));

    expect($faGlyphs)->not->toBeEmpty();

    foreach ($faGlyphs as [, , $text]) {
        expect(trim($text))->toBe('', "Ícone com texto em {$component}");
    }
})->with(ICON_COMPONENTS);

it('test_icon_prop_accepts_style_prefix', function () {
    $button = Blade::render('<x-jetax-button icon="regular:bell">Avisos</x-jetax-button>');
    $alert = Blade::render('<x-jetax-alert icon="brands:whatsapp">Enviado</x-jetax-alert>');

    expect($button)->toContain('fa-regular fa-bell')
        ->not->toContain('regular:')
        ->and($alert)->toContain('fa-brands fa-whatsapp')
        ->not->toContain('brands:');
});

it('test_icon_prop_without_prefix_is_solid', function () {
    expect(Blade::render('<x-jetax-button icon="bell">Avisos</x-jetax-button>'))->toContain('fa-solid fa-bell')
        ->and(Blade::render('<x-jetax-alert icon="bell">Aviso</x-jetax-alert>'))->toContain('fa-solid fa-bell');
});
