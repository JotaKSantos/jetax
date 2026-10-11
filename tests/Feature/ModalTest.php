<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Jetax\DesignSystem\View\Components\Modal;

function modalRootTag(string $html): string
{
    preg_match('/<div\s[^>]*role="dialog"[^>]*>/', $html, $matches);

    return $matches[0] ?? '';
}

function modalPanelTag(string $html): string
{
    preg_match('/<div\s[^>]*x-trap\.noscroll="open"[^>]*>/', $html, $matches);

    return $matches[0] ?? '';
}

function modalRootZIndex(string $html): int
{
    preg_match('/z-index:\s*(\d+)/', modalRootTag($html), $matches);

    return (int) ($matches[1] ?? 0);
}

it('test_hidden_by_default', function () {
    $view = $this->blade('<x-jetax-modal id="meu-modal">Conteúdo do modal</x-jetax-modal>');

    $view->assertSee('x-show', false);
    $view->assertSee('open', false);
});

it('test_id_attribute_used_in_alpine', function () {
    $view = $this->blade('<x-jetax-modal id="modal-teste">Conteúdo</x-jetax-modal>');

    $view->assertSee('modal-open.window', false);
    $view->assertSee('modal-teste', false);
});

it('test_size_classes_applied', function () {
    $smView = $this->blade('<x-jetax-modal id="m1" size="sm">Conteúdo</x-jetax-modal>');
    $smView->assertSee('max-w-xs', false);

    $mdView = $this->blade('<x-jetax-modal id="m2" size="md">Conteúdo</x-jetax-modal>');
    $mdView->assertSee('max-w-[560px]', false);

    $lgView = $this->blade('<x-jetax-modal id="m3" size="lg">Conteúdo</x-jetax-modal>');
    $lgView->assertSee('max-w-[660px]', false);

    $fsView = $this->blade('<x-jetax-modal id="m4" size="fullscreen">Conteúdo</x-jetax-modal>');
    $fsView->assertSee('max-w-full', false);
});

it('test_header_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-modal id="modal-header"><x-slot:header>Título do Modal</x-slot:header>Corpo</x-jetax-modal>'
    );

    $view->assertSee('Título do Modal');
});

it('test_footer_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-modal id="modal-footer">Corpo<x-slot:footer>Rodapé do Modal</x-slot:footer></x-jetax-modal>'
    );

    $view->assertSee('Rodapé do Modal');
});

it('test_aria_attributes_present', function () {
    $view = $this->blade('<x-jetax-modal id="modal-aria">Conteúdo</x-jetax-modal>');

    $view->assertSee('aria-modal="true"', false);
    $view->assertSee('role="dialog"', false);
});

it('test_backdrop_has_blur', function () {
    $view = $this->blade('<x-jetax-modal id="modal-blur">Conteúdo</x-jetax-modal>');

    $view->assertSee('blur(4px)', false);
});

it('test_consumer_attributes_and_class_reach_panel', function () {
    $html = Blade::render('<x-jetax-modal id="m" data-x="1" class="!max-w-2xl">Corpo</x-jetax-modal>');
    $panel = modalPanelTag($html);

    expect($panel)->toContain('data-x="1"')
        ->and($panel)->toContain('!max-w-2xl')
        ->and(substr_count($panel, 'class="'))->toBe(1)
        ->and(substr_count($html, 'data-x="1"'))->toBe(1);
});

it('test_panel_uses_surface_tokens', function () {
    $html = Blade::render('<x-jetax-modal id="m">Corpo</x-jetax-modal>');
    $panel = modalPanelTag($html);

    expect($panel)->toContain('bg-surface-container-lowest')
        ->and($panel)->toContain('border-outline-variant')
        ->and($html)->not->toContain('bg-white')
        ->and($html)->not->toContain('border-slate-');
});

it('test_header_uses_surface_tokens', function () {
    $html = Blade::render('<x-jetax-modal id="m"><x-slot:header>Título</x-slot:header> Corpo</x-jetax-modal>');

    expect($html)->toContain('bg-surface-container-lowest text-on-surface')
        ->and($html)->not->toContain('border-slate-');
});

it('test_body_uses_on_surface_variant_token', function () {
    $html = Blade::render('<x-jetax-modal id="m">Corpo</x-jetax-modal>');

    expect($html)->toContain('<div class="p-6 text-sm text-on-surface-variant leading-relaxed">')
        ->and($html)->not->toContain('text-slate-');
});

it('test_high_risk_uses_warning_tokens', function () {
    $html = Blade::render('<x-jetax-modal id="m" :high-risk="true">Conteúdo de risco</x-jetax-modal>');

    expect(modalPanelTag($html))->toContain('border-warning/20')
        ->and($html)->toContain('bg-warning/10 text-warning')
        ->and($html)->not->toContain('bg-amber-50')
        ->and($html)->not->toContain('text-amber-800')
        ->and($html)->not->toContain('amber-400');
});

it('test_level_raises_root_z_index', function () {
    $levelOne = Blade::render('<x-jetax-modal id="m1" level="1">Corpo</x-jetax-modal>');
    $levelTwo = Blade::render('<x-jetax-modal id="m2" level="2">Corpo</x-jetax-modal>');
    $levelThree = Blade::render('<x-jetax-modal id="m3" :level="3">Corpo</x-jetax-modal>');

    expect(modalRootZIndex($levelOne))->toBe(50)
        ->and(modalRootZIndex($levelTwo))->toBeGreaterThan(modalRootZIndex($levelOne))
        ->and(modalRootZIndex($levelThree))->toBeGreaterThan(modalRootZIndex($levelTwo));
});

it('test_default_level_is_one', function () {
    $html = Blade::render('<x-jetax-modal id="m">Corpo</x-jetax-modal>');

    expect(modalRootZIndex($html))->toBe(50)
        ->and(modalRootTag($html))->toContain('display: none;')
        ->and($html)->not->toContain('level=');
});

it('test_level_below_one_throws_in_testing', function () {
    expect(fn () => new Modal(level: 0))->toThrow(InvalidArgumentException::class, '"0"');
});

it('test_level_below_one_falls_back_in_production', function () {
    config(['app.env' => 'production']);
    Log::spy();

    expect((new Modal(level: 0))->zIndex())->toBe(50);

    Log::shouldHaveReceived('warning')->once();
});

it('test_open_and_close_window_events_are_kept', function () {
    $html = Blade::render('<x-jetax-modal id="modal-ev">Corpo</x-jetax-modal>');

    expect($html)->toContain('x-on:modal-open.window=')
        ->and($html)->toContain('x-on:modal-close.window=');
});

it('test_jetax_031_sizes_constant_keeps_old_keys_and_adds_new_ones', function () {
    expect(Modal::SIZES)->toBe(['sm', 'md', 'md-lg', 'lg', 'xl', '2xl', '3xl', 'fullscreen']);
});

it('test_jetax_031_size_maps_to_mockup_width', function (string $size, string $class) {
    expect((new Modal(size: $size))->sizeClasses())->toBe($class);

    $panel = modalPanelTag(Blade::render('<x-jetax-modal id="m" size="'.$size.'">Corpo</x-jetax-modal>'));

    expect($panel)->toContain($class);
})->with([
    'sm (320 px, inalterada)' => ['sm', 'max-w-xs'],
    'md (560 px)' => ['md', 'max-w-[560px]'],
    'md-lg (600 px)' => ['md-lg', 'max-w-[600px]'],
    'lg (660 px)' => ['lg', 'max-w-[660px]'],
    'xl (820 px)' => ['xl', 'max-w-[820px]'],
    '2xl (1080 px)' => ['2xl', 'max-w-[1080px]'],
    '3xl (980 px)' => ['3xl', 'max-w-[980px]'],
    'fullscreen (inalterada)' => ['fullscreen', 'w-full max-w-full h-full'],
]);

it('test_jetax_031_md_is_560px_and_no_longer_576px', function () {
    $panel = modalPanelTag(Blade::render('<x-jetax-modal id="m">Corpo</x-jetax-modal>'));

    expect($panel)->toContain('max-w-[560px]')
        ->and($panel)->not->toContain('max-w-xl');
});

it('test_jetax_031_lg_is_660px_and_no_longer_896px', function () {
    $panel = modalPanelTag(Blade::render('<x-jetax-modal id="m" size="lg">Corpo</x-jetax-modal>'));

    expect($panel)->toContain('max-w-[660px]')
        ->and($panel)->not->toContain('max-w-4xl');
});

it('test_jetax_031_md_lg_is_600px', function () {
    expect(modalPanelTag(Blade::render('<x-jetax-modal id="m" size="md-lg">Corpo</x-jetax-modal>')))
        ->toContain('max-w-[600px]');
});

it('test_jetax_031_xl_is_820px', function () {
    expect(modalPanelTag(Blade::render('<x-jetax-modal id="m" size="xl">Corpo</x-jetax-modal>')))
        ->toContain('max-w-[820px]');
});

it('test_jetax_031_2xl_is_1080px', function () {
    expect(modalPanelTag(Blade::render('<x-jetax-modal id="m" size="2xl">Corpo</x-jetax-modal>')))
        ->toContain('max-w-[1080px]');
});

it('test_jetax_031_3xl_is_980px', function () {
    expect(modalPanelTag(Blade::render('<x-jetax-modal id="m" size="3xl">Corpo</x-jetax-modal>')))
        ->toContain('max-w-[980px]');
});

it('test_jetax_031_panel_has_14px_radius_and_mockup_shadow', function () {
    $panel = modalPanelTag(Blade::render('<x-jetax-modal id="m">Corpo</x-jetax-modal>'));

    expect($panel)->toContain('rounded-[14px]')
        ->and($panel)->toContain('shadow-[0_24px_60px_rgb(9_42_66/0.16)]')
        ->and($panel)->not->toContain('rounded-xl')
        ->and($panel)->not->toContain('shadow-2xl');
});

it('test_jetax_031_high_risk_panel_keeps_radius_and_shadow', function () {
    $panel = modalPanelTag(Blade::render('<x-jetax-modal id="m" :high-risk="true">Corpo</x-jetax-modal>'));

    expect($panel)->toContain('rounded-[14px]')
        ->and($panel)->toContain('shadow-[0_24px_60px_rgb(9_42_66/0.16)]')
        ->and($panel)->toContain('border-warning/20');
});

it('test_jetax_031_invalid_size_throws_in_testing', function () {
    expect(fn () => new Modal(size: 'gigante'))->toThrow(InvalidArgumentException::class, '"gigante"');
});

it('test_jetax_031_invalid_size_logs_and_falls_back_to_md_in_production', function () {
    config(['app.env' => 'production']);
    Log::spy();

    $modal = new Modal(size: 'gigante');

    expect($modal->size)->toBe('md')
        ->and($modal->sizeClasses())->toBe('max-w-[560px]');

    Log::shouldHaveReceived('warning')->once();
});
