<?php

use Illuminate\Support\Facades\Blade;

function topbarHeaderTag(string $html): string
{
    preg_match('/<header\s[^>]*>/', $html, $matches);

    return $matches[0] ?? '';
}

it('has fixed positioning classes', function () {
    $view = $this->blade('<x-jetax::topbar title="Test" />');

    $view->assertSee('fixed', false);
    $view->assertSee('top-0', false);
    $view->assertSee('z-40', false);
});

it('renders actions slot', function () {
    $view = $this->blade('
        <x-jetax::topbar title="Test">
            <x-slot:actions>
                <button>Ação</button>
            </x-slot:actions>
        </x-jetax::topbar>
    ');

    $view->assertSee('Ação');
});

it('has hamburger button', function () {
    $view = $this->blade('<x-jetax::topbar />');

    $view->assertSee('Alternar menu');
});

it('test_dash_and_namespace_syntax_render_the_same_component', function () {
    expect(Blade::render('<x-jetax-topbar title="Agenda" sidebar-width="246px" />'))
        ->toBe(Blade::render('<x-jetax::topbar title="Agenda" sidebar-width="246px" />'));
});

it('test_has_no_embedded_search', function () {
    $html = Blade::render('<x-jetax::topbar />');

    expect($html)->not->toContain('placeholder="Pesquisar..."')
        ->not->toContain('<input');
});

it('test_left_actions_slot_renders_after_hamburger', function () {
    $html = Blade::render('
        <x-jetax::topbar>
            <x-slot:leftActions><span id="la"></span></x-slot:leftActions>
            <x-slot:actions><span id="ra"></span></x-slot:actions>
        </x-jetax::topbar>
    ');

    $hamburger = strpos($html, 'aria-label="Alternar menu"');
    $left = strpos($html, '<span id="la">');
    $right = strpos($html, '<span id="ra">');

    expect($hamburger)->toBeInt()
        ->and($left)->toBeGreaterThan($hamburger)
        ->and($right)->toBeGreaterThan($left)
        ->and(substr($html, $left, $right - $left))->toContain('</div>');
});

it('test_surface_matches_sidebar_in_both_themes', function () {
    $header = topbarHeaderTag(Blade::render('<x-jetax::topbar />'));

    expect($header)->toContain('bg-sidebar border-b border-outline-variant')
        ->not->toContain('dark:bg-')
        ->not->toContain('backdrop-blur');
});

it('test_sidebar_widths_come_from_props', function () {
    $custom = Blade::render('<x-jetax::topbar sidebar-width="246px" collapsed-width="72px" />');
    $default = Blade::render('<x-jetax::topbar />');

    expect($custom)->toContain('md:left-[246px]')
        ->and($custom)->toContain('md:left-[72px]')
        ->and($custom)->not->toContain('sidebar-width=')
        ->and($custom)->not->toContain('collapsed-width=')
        ->and($default)->toContain("\$store.sidebar.collapsed ? 'md:left-[70px]' : 'md:left-[16rem]'");
});

it('test_header_has_no_left_transition', function () {
    expect(topbarHeaderTag(Blade::render('<x-jetax::topbar />')))->not->toContain('transition-all');
});

it('test_title_is_rendered_when_given', function () {
    expect(Blade::render('<x-jetax::topbar title="Agenda" />'))
        ->toContain('<span class="hidden lg:block text-sm font-semibold text-on-surface-variant truncate">Agenda</span>')
        ->and(Blade::render('<x-jetax::topbar />'))->not->toContain('truncate">');
});

it('test_hamburger_button_matches_header_buttons', function () {
    $html = Blade::render('<x-jetax::topbar />');
    $start = strpos($html, '<button');
    $button = substr($html, $start, strpos($html, 'aria-label="Alternar menu"') - $start);

    expect($button)->toContain('w-[38px] h-[38px] rounded-[9px] border border-outline-variant bg-surface-container text-on-surface-variant')
        ->not->toContain('dark:text-slate-');
});
