<?php

use Illuminate\Support\Facades\Blade;

it('test_title_rendered_with_headline_font', function () {
    $view = $this->blade('<x-jetax-page-header title="Clientes" />');

    $view->assertSee('Clientes');
    $view->assertSee('font-headline', false);
});

it('test_subtitle_rendered_with_muted_class', function () {
    $view = $this->blade('<x-jetax-page-header title="Clientes" subtitle="Gerenciar base de clientes" />');

    $view->assertSee('Gerenciar base de clientes');
    $view->assertSee('text-on-surface-variant', false);
});

it('test_actions_slot_rendered_right', function () {
    $view = $this->blade('
        <x-jetax-page-header title="Clientes">
            <x-slot:actions>
                <button class="btn-primary">Novo Cliente</button>
            </x-slot:actions>
        </x-jetax-page-header>
    ');

    $view->assertSee('Novo Cliente');
    $view->assertSee('btn-primary', false);
});

it('test_breadcrumbs_rendered_when_prop_provided', function () {
    $breadcrumbs = [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Clientes'],
    ];

    $view = $this->blade('<x-jetax-page-header title="Clientes" :breadcrumbs="$breadcrumbs" />', [
        'breadcrumbs' => $breadcrumbs,
    ]);

    $view->assertSee('Home');
    $view->assertSee('Clientes');
    $view->assertSee('aria-label="Breadcrumb"', false);
});

it('test_no_breadcrumbs_when_empty', function () {
    $view = $this->blade('<x-jetax-page-header title="Dashboard" />');

    $view->assertDontSee('aria-label="Breadcrumb"', false);
});

it('test_no_subtitle_when_not_provided', function () {
    $view = $this->blade('<x-jetax-page-header title="Dashboard" />');

    $view->assertDontSee('<p', false);
});

it('test_without_icon_keeps_package_title_typography', function () {
    $html = Blade::render('<x-jetax-page-header title="Clientes" />');

    expect($html)->toContain('<h2 class="text-[2.25rem] font-headline font-light text-on-surface tracking-tight">Clientes</h2>')
        ->and($html)->not->toContain('w-11 h-11');
});

it('test_title_after_slot_is_inline_with_title', function () {
    $html = Blade::render('
        <x-jetax-page-header title="Clientes">
            <x-slot:titleAfter><a id="ajuda">?</a></x-slot:titleAfter>
        </x-jetax-page-header>
    ');

    expect($html)->toMatch('/<div class="flex items-center[^"]*">\s*<h2[^>]*>Clientes<\/h2>\s*<a id="ajuda">\?<\/a>\s*<\/div>/');
});

it('test_icon_renders_44px_square_before_title', function () {
    $html = Blade::render('<x-jetax-page-header title="Animais" icon="pets" />');

    expect($html)->toMatch('/<span class="w-11 h-11 flex-none rounded-\[11px\][^"]*">\s*<span class="material-symbols-outlined[^"]*">pets<\/span>\s*<\/span>\s*<h2/');
});

it('test_icon_square_uses_pri_to_pri_deep_gradient', function () {
    $html = Blade::render('<x-jetax-page-header title="Animais" icon="pets" />');

    expect($html)->toContain('bg-linear-to-br from-primary-container to-primary-deep')
        ->and($html)->not->toContain('from-brand-blue');

    $css = file_get_contents(__DIR__.'/../../resources/css/jetax.css');

    expect(substr_count($css, '--color-primary-deep: #003d69;'))->toBe(2);
});

it('test_icon_switches_title_to_design_typography', function () {
    $html = Blade::render('<x-jetax-page-header title="Animais" icon="pets" />');

    preg_match('/<h2 class="([^"]*)">/', $html, $matches);

    expect($matches[1] ?? '')->toContain('text-[1.625rem]')
        ->toContain('font-bold')
        ->not->toContain('text-[2.25rem]')
        ->not->toContain('font-light');
});

it('test_icon_attribute_does_not_leak', function () {
    $html = Blade::render('<x-jetax-page-header title="Animais" icon="pets" heading="h1" subtitle-beside-icon />');

    expect($html)->not->toContain('icon=')
        ->not->toContain('heading=')
        ->not->toContain('subtitle-beside-icon');
});

it('test_bottom_padding_depends_on_icon', function () {
    expect(Blade::render('<x-jetax-page-header title="Animais" icon="pets" />'))->toContain('<div class="pb-5">')
        ->and(Blade::render('<x-jetax-page-header title="Animais" />'))->toContain('<div class="pb-9">');
});

it('test_heading_attribute_switches_title_tag', function () {
    $h1 = Blade::render('<x-jetax-page-header title="A receber" icon="payments" heading="h1" />');
    $default = Blade::render('<x-jetax-page-header title="A receber" />');
    $other = Blade::render('<x-jetax-page-header title="A receber" heading="h3" />');

    expect($h1)->toMatch('/<h1 class="[^"]*text-\[1\.625rem\][^"]*">A receber<\/h1>/')
        ->and($h1)->not->toContain('<h2')
        ->and($default)->toContain('<h2 ')
        ->and($other)->toContain('<h2 ')
        ->and($other)->not->toContain('<h3')
        ->and($h1.$default.$other)->not->toContain('heading=');
});

it('test_subtitle_beside_icon_renders_column_to_the_right_of_square', function () {
    $html = Blade::render('
        <x-jetax-page-header title="Grupos" subtitle="Sub" icon="stacks" subtitle-beside-icon>
            <x-slot:titleAfter><a id="ajuda">?</a></x-slot:titleAfter>
        </x-jetax-page-header>
    ');

    expect($html)->toMatch(
        '/<div class="flex items-center gap-3\.5">\s*'
        .'<span class="w-11 h-11[^"]*">\s*<span class="material-symbols-outlined[^"]*">stacks<\/span>\s*<\/span>\s*'
        .'<div>\s*<div class="flex items-center[^"]*">\s*<h2[^>]*>Grupos<\/h2>\s*<a id="ajuda">\?<\/a>\s*<\/div>\s*'
        .'<p class="text-sm text-on-surface-variant mt-0\.5">Sub<\/p>\s*<\/div>\s*<\/div>/'
    );
});

it('test_subtitle_beside_icon_requires_icon', function () {
    $with = Blade::render('<x-jetax-page-header title="Grupos" subtitle="Sub" subtitle-beside-icon />');
    $without = Blade::render('<x-jetax-page-header title="Grupos" subtitle="Sub" />');

    expect($with)->toBe($without)
        ->and($with)->not->toContain('subtitle-beside-icon');
});

it('test_subtitle_uses_on_surface_variant_token', function () {
    $plain = Blade::render('<x-jetax-page-header title="Clientes" subtitle="Sub" />');
    $withIcon = Blade::render('<x-jetax-page-header title="Clientes" subtitle="Sub" icon="pets" />');

    expect($plain)->toContain('<p class="text-sm text-on-surface-variant mt-1">Sub</p>')
        ->and($withIcon)->toContain('<p class="text-sm text-on-surface-variant mt-1">Sub</p>')
        ->and($plain.$withIcon)->not->toContain('slate-');
});
