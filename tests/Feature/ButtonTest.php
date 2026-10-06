<?php

use Illuminate\Support\Facades\Log;

it('test_solid_style_has_bg_class', function () {
    $view = $this->blade('<x-jetax-button style="solid" color="primary">Clique</x-jetax-button>');

    $view->assertSee('bg-primary', false);
});

it('test_outline_style_has_border_class', function () {
    $view = $this->blade('<x-jetax-button style="outline" color="primary">Clique</x-jetax-button>');

    $view->assertSee('border-primary', false);
    $view->assertSee('border-2', false);
});

it('test_soft_style_has_light_bg_class', function () {
    $view = $this->blade('<x-jetax-button style="soft" color="primary">Clique</x-jetax-button>');

    $view->assertSee('bg-primary/10', false);
});

it('test_all_8_colors_render', function () {
    $colors = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark', 'light'];

    foreach ($colors as $color) {
        $view = $this->blade("<x-jetax-button color=\"{$color}\">Botão</x-jetax-button>");
        $view->assertSee('<button', false);
    }
});

it('test_3_sizes_render_correct_classes', function () {
    $smView = $this->blade('<x-jetax-button size="sm">Pequeno</x-jetax-button>');
    $smView->assertSee('px-3', false);
    $smView->assertSee('py-1.5', false);
    $smView->assertSee('text-xs', false);
    $smView->assertSee('rounded-lg', false);

    $mdView = $this->blade('<x-jetax-button size="md">Médio</x-jetax-button>');
    $mdView->assertSee('px-5', false);
    $mdView->assertSee('py-2.5', false);
    $mdView->assertSee('text-sm', false);
    $mdView->assertSee('rounded-xl', false);

    $lgView = $this->blade('<x-jetax-button size="lg">Grande</x-jetax-button>');
    $lgView->assertSee('px-8', false);
    $lgView->assertSee('py-4', false);
    $lgView->assertSee('text-lg', false);
    $lgView->assertSee('font-headline', false);
});

it('test_block_prop_applies_full_width', function () {
    $view = $this->blade('<x-jetax-button :block="true">Bloco</x-jetax-button>');

    $view->assertSee('w-full', false);
});

it('test_loading_state_shows_spinner', function () {
    $view = $this->blade('<x-jetax-button :loading="true">Aguarde</x-jetax-button>');

    $view->assertSee('animate-spin', false);
    $view->assertSee('disabled', false);
});

it('test_disabled_attribute_passthrough', function () {
    $view = $this->blade('<x-jetax-button disabled>Desabilitado</x-jetax-button>');

    $view->assertSee('disabled', false);
    $view->assertSee('cursor-not-allowed', false);
});

it('test_icon_rendered_left_and_right', function () {
    $leftView = $this->blade('<x-jetax-button icon="search" icon-position="left">Buscar</x-jetax-button>');
    $leftView->assertSeeInOrder(['material-symbols-outlined', 'Buscar'], false);

    $rightView = $this->blade('<x-jetax-button icon="arrow_forward" icon-position="right">Avançar</x-jetax-button>');
    $rightView->assertSeeInOrder(['Avançar', 'material-symbols-outlined'], false);
});

it('test_all_6_styles_x_8_colors_x_3_sizes_render', function () {
    $styles = ['solid', 'rounded', 'outline', 'outline-rounded', 'soft', 'soft-rounded'];
    $colors = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark', 'light'];
    $sizes = ['sm', 'md', 'lg'];

    foreach ($styles as $style) {
        foreach ($colors as $color) {
            foreach ($sizes as $size) {
                $view = $this->blade(
                    "<x-jetax-button style=\"{$style}\" color=\"{$color}\" size=\"{$size}\">Botão</x-jetax-button>"
                );
                $view->assertSee('<button', false);
            }
        }
    }
});

it('test_invalid_color_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-button color="tertiary">Botão</x-jetax-button>'))->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_icon_only_renders_square_without_horizontal_padding', function (string $size, string $square) {
    $html = (string) $this->blade(
        "<x-jetax-button icon-only size=\"{$size}\" icon=\"delete\" aria-label=\"Excluir\" />"
    );

    expect(htmlTag($html, 'button'))->toContain($square)
        ->not->toMatch('/\bpx-\d/')
        ->not->toMatch('/\bpy-\d/');
})->with([
    ['sm', 'w-8 h-8'],
    ['md', 'w-11 h-11'],
    ['lg', 'w-12 h-12'],
]);

it('test_icon_only_md_has_w_11_h_11_and_no_px_5', function () {
    $html = (string) $this->blade('<x-jetax-button icon-only size="md" icon="edit" title="Editar" />');

    expect($html)->toContain('w-11 h-11')
        ->not->toContain('px-5')
        ->toContain('title="Editar"')
        ->not->toContain('icon-only');
});

it('test_icon_only_keeps_glyph_size', function () {
    $html = (string) $this->blade('<x-jetax-button icon-only size="lg" icon="edit" aria-label="Editar" />');

    expect($html)->toContain('<span class="material-symbols-outlined">edit</span>');
});

it('test_icon_only_without_accessible_name_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-button icon-only icon="delete" />'))
        ->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_icon_only_with_aria_label_title_or_slot_text_renders', function (string $template) {
    expect(bladeRenderFailure($template))->toBeNull();
})->with([
    'aria-label' => ['<x-jetax-button icon-only icon="delete" aria-label="Excluir" />'],
    'title' => ['<x-jetax-button icon-only icon="delete" title="Excluir" />'],
    'texto no slot' => ['<x-jetax-button icon-only icon="delete"><span class="sr-only">Excluir</span></x-jetax-button>'],
]);

it('test_icon_only_without_accessible_name_logs_and_renders_in_production', function () {
    config()->set('app.env', 'production');
    Log::spy();

    $html = (string) $this->blade('<x-jetax-button icon-only icon="delete" />');

    expect($html)->toContain('w-11 h-11');
    Log::shouldHaveReceived('warning')->once();
});

it('test_custom_color_uses_css_token_background', function () {
    $html = (string) $this->blade('<x-jetax-button color="custom" color-token="brand-blue">Salvar</x-jetax-button>');

    expect(htmlTag($html, 'button'))->toContain('bg-[var(--color-brand-blue)]')
        ->toContain('text-white')
        ->toContain('style="background-color: var(--color-brand-blue)"')
        ->not->toContain('bg-primary')
        ->not->toContain('color-token=');
});

it('test_custom_color_outline_and_soft_use_css_token', function () {
    $outline = (string) $this->blade('<x-jetax-button style="outline" color="custom" color-token="brand-blue">Ok</x-jetax-button>');
    $soft = (string) $this->blade('<x-jetax-button style="soft" color="custom" color-token="brand-blue">Ok</x-jetax-button>');

    expect(htmlTag($outline, 'button'))->toContain('border-[var(--color-brand-blue)]')
        ->toContain('text-[var(--color-brand-blue)]')
        ->not->toContain('style=')
        ->and(htmlTag($soft, 'button'))->toContain('bg-[var(--color-brand-blue)]/10');
});

it('test_custom_color_keeps_single_class_attribute', function () {
    $html = (string) $this->blade('<x-jetax-button color="custom" color-token="brand-blue" style="solid" class="probe-xyz">Ok</x-jetax-button>');

    expect(substr_count(htmlTag($html, 'button'), 'class="'))->toBe(1)
        ->and(htmlTag($html, 'button'))->toContain('probe-xyz');
});

it('test_custom_color_without_token_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-button color="custom">Ok</x-jetax-button>'))
        ->toBeInstanceOf(InvalidArgumentException::class);
});
