<?php

use Illuminate\Support\Facades\Blade;

it('test_value_rendered_with_headline_font', function () {
    $view = $this->blade('<x-jetax-stats-card label="Receita" value="R$ 142.380,00" />');

    $view->assertSee('font-headline', false);
});

it('test_up_trend_has_success_text_class', function () {
    $view = $this->blade('<x-jetax-stats-card label="Receita" value="R$ 142.380,00" trend="up" trend-value="12.5%" />');

    $view->assertSee('text-success-text', false);
    $view->assertDontSee('text-green-600', false);
});

it('test_down_trend_has_red_class', function () {
    $view = $this->blade('<x-jetax-stats-card label="Inadimplência" value="4.2%" trend="down" trend-value="5.1%" />');

    $view->assertSee('text-error', false);
});

it('test_highlighted_has_gradient_class', function () {
    $view = $this->blade('<x-jetax-stats-card label="Receita" value="R$ 142.380,00" :highlighted="true" />');

    $view->assertSee('primary-gradient', false);
});

it('test_neutral_card_uses_surface_tokens', function () {
    $html = Blade::render('<x-jetax-stats-card label="Receita" value="10" icon="money-bills" trend="neutral" trend-value="0%" />');
    $root = tagClass(htmlTag($html, 'div'));

    expect($root)->toContain('bg-surface-container-lowest')->toContain('border-outline-variant');

    foreach (['bg-white', 'text-slate-', 'bg-green-50', 'bg-red-50', 'bg-slate-50'] as $literal) {
        expect($html)->not->toContain($literal);
    }
});

it('test_danger_tone_renders_solid_card', function () {
    $html = Blade::render('<x-jetax-stats-card label="Saldo devedor" value="R$ 10,00" tone="danger" />');

    expect(tagClass(htmlTag($html, 'div')))->toContain('bg-danger-solid')->toContain('border-danger-solid');
    expect($html)->toContain('text-on-primary/75')->toContain('font-headline font-bold text-3xl text-on-primary');
});

it('test_each_tone_decides_solid_surface', function (string $tone, string $surface) {
    $html = Blade::render('<x-jetax-stats-card label="Total" value="1" tone="'.$tone.'" />');

    expect(tagClass(htmlTag($html, 'div')))->toContain($surface)->toContain('text-on-primary');
})->with([
    'neutral' => ['neutral', 'bg-neutral-solid'],
    'success' => ['success', 'bg-success-solid'],
    'danger' => ['danger', 'bg-danger-solid'],
    'warning' => ['warning', 'bg-warning-solid'],
    'info' => ['info', 'bg-primary-container'],
]);

it('test_tone_does_not_leak_as_attribute', function () {
    $html = Blade::render('<x-jetax-stats-card label="Total" value="1" tone="danger" layout="figure" hint="Ajuda" />');

    expect($html)->not->toContain('tone=')->not->toContain('layout=')->not->toContain(' hint=');
});

it('test_invalid_tone_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-stats-card label="Total" value="1" tone="primary" />'))
        ->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_highlighted_card_keeps_gradient', function () {
    $html = Blade::render('<x-jetax-stats-card label="Receita" value="1" :highlighted="true" />');

    expect(tagClass(htmlTag($html, 'div')))->toContain('primary-gradient')->toContain('text-on-primary');
    expect($html)->not->toContain('text-white');
});

it('test_label_and_value_use_tokens', function () {
    $html = Blade::render('<x-jetax-stats-card label="Receita" value="1" />');

    expect($html)
        ->toContain('text-on-surface-variant')
        ->toContain('font-headline font-bold text-3xl text-on-surface')
        ->not->toContain('text-slate-');
});

it('test_icon_uses_tokens_per_surface', function () {
    $neutral = Blade::render('<x-jetax-stats-card label="Receita" value="1" icon="money-bills" />');
    $solid = Blade::render('<x-jetax-stats-card label="Receita" value="1" icon="money-bills" tone="danger" />');

    expect($neutral)->toContain('bg-primary/10')->toContain('fa-solid fa-money-bills text-[18px] text-primary');
    expect($solid)->toContain('bg-on-primary/20')->toContain('fa-solid fa-money-bills text-[18px] text-on-primary');
});

it('test_trend_uses_tokens', function () {
    $up = Blade::render('<x-jetax-stats-card label="A" value="1" trend="up" trend-value="+1%" />');
    $down = Blade::render('<x-jetax-stats-card label="A" value="1" trend="down" trend-value="-1%" />');
    $flat = Blade::render('<x-jetax-stats-card label="A" value="1" trend="neutral" trend-value="0%" />');

    expect($up)->toContain('text-success-text');
    expect($down)->toContain('text-error');
    expect($flat)->toContain('text-on-surface-variant bg-surface-container-high');

    foreach ([$up, $down, $flat] as $html) {
        expect($html)->not->toContain('bg-green-50')->not->toContain('bg-red-50')->not->toContain('bg-slate-50');
    }
});

it('test_figure_layout_renders_solid_icon_left_and_right_aligned_text', function () {
    $html = Blade::render('<x-jetax-stats-card label="Atendimentos" value="42" icon="paw" layout="figure" tone="neutral" />');

    expect(tagClass(htmlTag($html, 'div')))->toContain('bg-neutral-solid');

    $iconPosition = strpos($html, 'fa-paw');
    $textBlockPosition = strpos($html, 'text-right');

    expect($iconPosition)->not->toBeFalse();
    expect($textBlockPosition)->not->toBeFalse();
    expect($iconPosition)->toBeLessThan($textBlockPosition);
    expect(strpos($html, '>42<'))->toBeLessThan(strpos($html, 'Atendimentos'));
    expect($html)->toContain('bg-on-primary/20');
});

it('test_figure_layout_defaults_to_neutral_tone', function () {
    $html = Blade::render('<x-jetax-stats-card label="Atendimentos" value="42" icon="paw" layout="figure" />');

    expect(tagClass(htmlTag($html, 'div')))->toContain('bg-neutral-solid');
});

it('test_figure_layout_accepts_info_tone', function () {
    $html = Blade::render('<x-jetax-stats-card label="Agendados" value="7" icon="regular:calendar" layout="figure" tone="info" />');

    expect(tagClass(htmlTag($html, 'div')))->toContain('bg-primary-container')->toContain('text-on-primary');
});

it('test_hint_renders_marker_with_title_before_label', function () {
    $html = Blade::render('<x-jetax-stats-card label="Saldo" value="1" hint="x" />');

    expect($html)->toContain('title="x"');
    expect(strpos($html, 'title="x"'))->toBeLessThan(strpos($html, '>Saldo<'));

    $figure = Blade::render('<x-jetax-stats-card label="Saldo" value="1" hint="Valor em aberto" layout="figure" />');

    expect($figure)->toContain('title="Valor em aberto"');
});

it('test_without_hint_has_no_marker', function () {
    $html = Blade::render('<x-jetax-stats-card label="Saldo" value="1" />');

    expect($html)->not->toContain('title=')->not->toContain('cursor-help');
});

it('test_without_layout_keeps_default_arrangement', function () {
    $html = Blade::render('<x-jetax-stats-card label="Saldo" value="1" />');

    expect(tagClass(htmlTag($html, 'div')))->toContain('flex-col')->toContain('p-6');
    expect($html)->not->toContain('text-right');
});

it('test_stats_card_files_have_no_literal_palette', function () {
    $root = __DIR__.'/../..';
    $contents = file_get_contents($root.'/resources/views/components/stats-card.blade.php')
        .file_get_contents($root.'/src/View/Components/StatsCard.php');

    expect($contents)
        ->not->toMatch('/(?:text|bg|border|ring|from|to|fill|stroke)-\[#/')
        ->not->toMatch('/(?:bg-white|text-white|-slate-|bg-(?:red|green|amber|slate)-50)/');
});

it('test_trend_icon_is_font_awesome', function (string $trend, string $icon) {
    $html = Blade::render("<x-jetax-stats-card label=\"A\" value=\"1\" trend=\"{$trend}\" trend-value=\"1%\" />");

    expect(htmlTag($html, 'i', $icon))->toContain("fa-solid {$icon}")
        ->toContain('aria-hidden="true"')
        ->and($html)->not->toContain('material');
})->with([
    ['up', 'fa-arrow-trend-up'],
    ['down', 'fa-arrow-trend-down'],
    ['neutral', 'fa-arrow-right-long'],
]);

it('test_icon_accepts_style_prefix', function () {
    $html = Blade::render('<x-jetax-stats-card label="A" value="1" icon="regular:calendar" />');

    expect($html)->toContain('fa-regular fa-calendar')
        ->not->toContain('regular:');
});
