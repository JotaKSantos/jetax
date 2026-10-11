<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Jetax\DesignSystem\View\Components\Badge;

it('test_all_variants_render', function () {
    $variants = ['success', 'danger', 'warning', 'info', 'neutral'];

    foreach ($variants as $variant) {
        $view = $this->blade('<x-jetax-badge :variant="$variant">Teste</x-jetax-badge>', ['variant' => $variant]);

        $view->assertSee('Teste');
    }
});

it('test_dot_indicator_present', function () {
    $view = $this->blade('<x-jetax-badge variant="success" style="status">Ativo</x-jetax-badge>');

    $view->assertSee('w-2 h-2', false);
    $view->assertSee('rounded-full', false);
});

it('test_soft_has_10_percent_bg', function () {
    $view = $this->blade('<x-jetax-badge variant="success" style="soft">Success</x-jetax-badge>');

    $view->assertSee('bg-success/10', false);
});

it('test_solid_has_full_bg', function () {
    $view = $this->blade('<x-jetax-badge variant="success" style="solid">Success</x-jetax-badge>');

    $view->assertSee('bg-success-solid', false);
    $view->assertSee('text-white', false);
});

it('test_square_variant_has_smaller_radius', function () {
    $view = $this->blade('<x-jetax-badge variant="neutral" :square="true">Quadrado</x-jetax-badge>');

    $view->assertSee('rounded-lg', false);
    $view->assertDontSee('rounded-full', false);
});

it('test_success_variant_has_success_token_classes', function () {
    $view = $this->blade('<x-jetax-badge variant="success" style="soft">Success</x-jetax-badge>');

    $view->assertSee('text-success-text', false);
    $view->assertDontSee('green', false);
});

it('test_color_is_alias_of_variant_and_does_not_leak', function () {
    $html = Blade::render('<x-jetax-badge color="danger" style="status">Bloquear</x-jetax-badge>');

    expect($html)
        ->toContain('text-error')
        ->not->toContain('color="danger"')
        ->not->toContain('color=');
});

it('test_color_takes_precedence_over_variant', function () {
    $html = Blade::render('<x-jetax-badge variant="success" color="warning">Pendente</x-jetax-badge>');

    expect($html)->toContain('text-warning')->not->toContain('text-success-text');
});

it('test_invalid_variant_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-badge variant="secondary" style="status">Avisar</x-jetax-badge>'))->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_invalid_color_alias_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-badge color="primary">x</x-jetax-badge>'))->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_badge_uses_tokens_without_hex_or_named_palette', function () {
    $source = file_get_contents(__DIR__.'/../../src/View/Components/Badge.php');

    expect($source)->not->toMatch('/\[#[0-9a-fA-F]{3,8}\]/');
    expect($source)->not->toMatch('/(?:bg|text|border)-(?:slate|gray|green|amber|cyan|blue|red)-\d/');
});

it('test_jetax_035_text_cases_constant', function () {
    expect(Badge::TEXT_CASES)->toBe(['upper', 'normal']);
});

it('test_jetax_035_default_text_case_keeps_uppercase', function () {
    $span = htmlTag(Blade::render('<x-jetax-badge>Ativo</x-jetax-badge>'), 'span');

    expect($span)->toContain('uppercase tracking-wider')
        ->and($span)->not->toContain('normal-case');
});

it('test_jetax_035_text_case_normal_drops_uppercase_and_tracking', function () {
    $html = Blade::render('<x-jetax-badge text-case="normal">Em aberto</x-jetax-badge>');
    $span = htmlTag($html, 'span');

    expect($span)->toContain('normal-case tracking-normal')
        ->and($span)->not->toContain('uppercase')
        ->and($span)->not->toContain('tracking-wider')
        ->and($span)->not->toContain('text-case=');
});

it('test_jetax_035_text_case_normal_on_status_style', function () {
    $span = htmlTag(Blade::render('<x-jetax-badge style="status" variant="success" text-case="normal">Pago</x-jetax-badge>'), 'span');

    expect($span)->toContain('normal-case')
        ->and($span)->not->toContain('uppercase');
});

it('test_jetax_035_radius_is_6px_when_not_square', function () {
    $span = htmlTag(Blade::render('<x-jetax-badge>Ativo</x-jetax-badge>'), 'span');

    expect($span)->toContain('rounded-[6px]')
        ->and($span)->not->toContain('rounded-full');
});

it('test_jetax_035_md_padding_and_height_follow_mockup', function () {
    $span = htmlTag(Blade::render('<x-jetax-badge size="md">Ativo</x-jetax-badge>'), 'span');

    expect($span)->toContain('px-2 py-0.5 leading-[15px]')
        ->and($span)->not->toContain('px-3 py-1 ');
});

it('test_jetax_035_status_style_has_no_border', function (string $variant) {
    $span = htmlTag(Blade::render('<x-jetax-badge style="status" variant="'.$variant.'">x</x-jetax-badge>'), 'span');

    expect($span)->not->toMatch('/\bborder\b/')
        ->and($span)->not->toContain('border-');
})->with(['success', 'danger', 'warning', 'info', 'neutral']);

it('test_jetax_035_invalid_text_case_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-badge text-case="lower">x</x-jetax-badge>'))->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_jetax_035_invalid_text_case_logs_and_falls_back_to_upper_in_production', function () {
    config(['app.env' => 'production']);
    Log::spy();

    $badge = new Badge(textCase: 'lower');

    expect($badge->textCase)->toBe('upper')
        ->and($badge->textCaseClasses())->toBe('uppercase tracking-wider');

    Log::shouldHaveReceived('warning')->once();
});
