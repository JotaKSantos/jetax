<?php

use Illuminate\Support\Facades\Blade;

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
