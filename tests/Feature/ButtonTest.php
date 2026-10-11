<?php

use Illuminate\Support\Facades\Log;
use Jetax\DesignSystem\View\Components\Button;

it('test_solid_style_has_bg_class', function () {
    $view = $this->blade('<x-jetax-button style="solid" color="primary">Clique</x-jetax-button>');

    $view->assertSee('bg-primary', false);
});

it('test_outline_style_has_border_class', function () {
    $view = $this->blade('<x-jetax-button style="outline" color="primary">Clique</x-jetax-button>');

    // JETAX-029: a borda do outline é de 1 px (`border`), não mais `border-2`.
    expect(tagClass(htmlTag((string) $view, 'button')))->toMatch('/(^|\s)border(\s|$)/')
        ->not->toContain('border-2');
    $view->assertSee('border-primary', false);
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
    // JETAX-029: altura fixa por tamanho, sem padding vertical.
    $smView = $this->blade('<x-jetax-button size="sm">Pequeno</x-jetax-button>');
    $smView->assertSee('h-[34px] px-3 text-xs rounded-[8px]', false);

    $mdView = $this->blade('<x-jetax-button size="md">Médio</x-jetax-button>');
    $mdView->assertSee('h-11 px-5 text-sm rounded-xl', false);

    $lgView = $this->blade('<x-jetax-button size="lg">Grande</x-jetax-button>');
    $lgView->assertSee('h-[52px] px-8 text-lg rounded-[10px] font-headline', false);

    foreach ([$smView, $mdView, $lgView] as $view) {
        expect(tagClass(htmlTag((string) $view, 'button')))->not->toMatch('/\bpy-/');
    }
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
    $leftView = $this->blade('<x-jetax-button icon="magnifying-glass" icon-position="left">Buscar</x-jetax-button>');
    $leftView->assertSeeInOrder(['fa-solid fa-magnifying-glass', 'Buscar'], false);

    $rightView = $this->blade('<x-jetax-button icon="arrow-right" icon-position="right">Avançar</x-jetax-button>');
    $rightView->assertSeeInOrder(['Avançar', 'fa-solid fa-arrow-right'], false);
});

it('test_glyph_size_follows_button_size', function (string $size, string $glyphClass, string $template) {
    $html = (string) $this->blade(sprintf($template, $size));
    $glyph = htmlTag($html, 'i', 'fa-bell');

    preg_match_all('/\btext-\[\d+px\]/', tagClass($glyph), $sizeClasses);

    expect($sizeClasses[0])->toBe([$glyphClass])
        ->and($glyph)->not->toContain('style=')
        ->toContain('aria-hidden="true"')
        ->and($html)->toContain($glyph.'</i>');
})->with([
    'sm' => ['sm', 'text-[12px]'],
    'md' => ['md', 'text-[15px]'],
    'lg' => ['lg', 'text-[18px]'],
    'field' => ['field', 'text-[14px]'],
])->with([
    'esquerda' => ['<x-jetax-button size="%s" icon="bell" icon-position="left">Avisos</x-jetax-button>'],
    'direita' => ['<x-jetax-button size="%s" icon="bell" icon-position="right">Avisos</x-jetax-button>'],
]);

it('test_icon_accepts_style_prefix', function () {
    $html = (string) $this->blade('<x-jetax-button icon="regular:bell">Avisos</x-jetax-button>');

    expect($html)->toContain('fa-regular fa-bell')
        ->not->toContain('regular:')
        ->not->toContain('fa-solid');
});

it('test_icon_without_prefix_is_solid', function () {
    $html = (string) $this->blade('<x-jetax-button icon="bell">Avisos</x-jetax-button>');

    expect($html)->toContain('fa-solid fa-bell');
});

it('test_icon_with_invalid_style_prefix_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-button icon="outlined:bell">Avisos</x-jetax-button>'))
        ->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_all_6_styles_x_8_colors_x_3_sizes_render', function () {
    $styles = ['solid', 'rounded', 'outline', 'outline-rounded', 'soft', 'soft-rounded'];
    $colors = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark', 'light'];
    $sizes = ['sm', 'md', 'lg', 'field'];

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
        "<x-jetax-button icon-only size=\"{$size}\" icon=\"trash\" aria-label=\"Excluir\" />"
    );

    expect(htmlTag($html, 'button'))->toContain($square)
        ->not->toMatch('/\bpx-\d/')
        ->not->toMatch('/\bpy-\d/');
})->with([
    ['sm', 'w-[34px] h-[34px]'],
    ['md', 'w-11 h-11'],
    ['lg', 'w-12 h-12'],
    ['field', 'w-10 h-10'],
]);

it('test_icon_only_md_has_w_11_h_11_and_no_px_5', function () {
    $html = (string) $this->blade('<x-jetax-button icon-only size="md" icon="pen" title="Editar" />');

    expect($html)->toContain('w-11 h-11')
        ->not->toContain('px-5')
        ->toContain('title="Editar"')
        ->not->toContain('icon-only');
});

it('test_icon_only_keeps_glyph_size', function () {
    $html = (string) $this->blade('<x-jetax-button icon-only size="lg" icon="pen" aria-label="Editar" />');

    expect($html)->toContain('<i class="fa-solid fa-pen text-[18px]" aria-hidden="true"></i>');
});

it('test_icon_only_without_accessible_name_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-button icon-only icon="trash" />'))
        ->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_icon_only_with_aria_label_title_or_slot_text_renders', function (string $template) {
    expect(bladeRenderFailure($template))->toBeNull();
})->with([
    'aria-label' => ['<x-jetax-button icon-only icon="trash" aria-label="Excluir" />'],
    'title' => ['<x-jetax-button icon-only icon="trash" title="Excluir" />'],
    'texto no slot' => ['<x-jetax-button icon-only icon="trash"><span class="sr-only">Excluir</span></x-jetax-button>'],
]);

it('test_icon_only_without_accessible_name_logs_and_renders_in_production', function () {
    config()->set('app.env', 'production');
    Log::spy();

    $html = (string) $this->blade('<x-jetax-button icon-only icon="trash" />');

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

it('test_jetax_029_md_solid_is_44px_without_vertical_padding', function () {
    $class = tagClass(htmlTag((string) $this->blade('<x-jetax-button>Incluir</x-jetax-button>'), 'button'));

    expect($class)->toContain('h-11 px-5 text-sm rounded-xl')
        ->not->toContain('py-2.5');
});

it('test_jetax_029_md_outline_is_40px_with_18px_padding_and_1px_border', function (string $style) {
    $class = tagClass(htmlTag((string) $this->blade("<x-jetax-button style=\"{$style}\">Atualizar</x-jetax-button>"), 'button'));

    expect($class)->toContain('h-10 px-[18px] text-sm')
        ->toMatch('/(^|\s)border(\s|$)/')
        ->not->toContain('border-2')
        ->not->toContain('h-11')
        ->not->toContain('px-5');
})->with(['outline', 'outline-rounded']);

it('test_jetax_029_outline_border_is_1px_in_every_color_and_disabled', function () {
    foreach ([...Button::COLORS] as $color) {
        $html = (string) $this->blade("<x-jetax-button style=\"outline\" color=\"{$color}\">Ok</x-jetax-button>");
        expect(tagClass(htmlTag($html, 'button')))->not->toContain('border-2');
    }

    $custom = (string) $this->blade('<x-jetax-button style="outline" color="custom" color-token="brand-blue">Ok</x-jetax-button>');
    $disabled = (string) $this->blade('<x-jetax-button style="outline" disabled>Ok</x-jetax-button>');

    expect(tagClass(htmlTag($custom, 'button')))->not->toContain('border-2')
        ->and(tagClass(htmlTag($disabled, 'button')))->not->toContain('border-2');
});

it('test_jetax_029_field_size_is_40px_with_8px_radius', function () {
    $class = tagClass(htmlTag((string) $this->blade('<x-jetax-button size="field">Buscar</x-jetax-button>'), 'button'));

    expect($class)->toContain('h-10 px-[18px] text-sm rounded-[8px]');
});

it('test_jetax_030_md_glyph_is_15px', function () {
    $html = (string) $this->blade('<x-jetax-button icon="rotate">Atualizar</x-jetax-button>');

    expect(tagClass(htmlTag($html, 'i', 'fa-rotate')))->toContain('text-[15px]')
        ->not->toContain('text-[14px]');
});

it('test_jetax_030_icon_only_glyph_follows_icon_only_map', function (string $size, string $glyphClass) {
    $html = (string) $this->blade("<x-jetax-button icon-only size=\"{$size}\" icon=\"bell\" aria-label=\"Avisos\" />");

    preg_match_all('/\btext-\[\d+px\]/', tagClass(htmlTag($html, 'i', 'fa-bell')), $sizeClasses);

    expect($sizeClasses[0])->toBe([$glyphClass]);
})->with([
    'sm' => ['sm', 'text-[14px]'],
    'md' => ['md', 'text-[15px]'],
    'lg' => ['lg', 'text-[18px]'],
    'field' => ['field', 'text-[14px]'],
]);

it('test_jetax_030_icon_only_sm_is_34px_square_with_8px_radius', function () {
    $class = tagClass(htmlTag((string) $this->blade('<x-jetax-button icon-only size="sm" icon="pen" aria-label="Editar" />'), 'button'));

    expect($class)->toContain('w-[34px] h-[34px]')
        ->toContain('rounded-[8px]')
        ->not->toContain('w-8 h-8');
});

it('test_jetax_030_icon_only_md_has_10px_radius', function () {
    $class = tagClass(htmlTag((string) $this->blade('<x-jetax-button icon-only icon="rotate" aria-label="Atualizar" />'), 'button'));

    expect($class)->toContain('w-11 h-11')
        ->toContain('rounded-[10px]')
        ->not->toContain('rounded-xl');
});

it('test_jetax_030_icon_only_field_is_40px_square_with_8px_radius', function () {
    $class = tagClass(htmlTag((string) $this->blade('<x-jetax-button icon-only size="field" icon="plus" aria-label="Incluir" />'), 'button'));

    expect($class)->toContain('w-10 h-10')
        ->toContain('rounded-[8px]')
        ->not->toMatch('/\bpx-/');
});

it('test_invalid_size_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-button size="xl">Botão</x-jetax-button>'))
        ->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_invalid_size_logs_and_falls_back_to_md_in_production', function () {
    config()->set('app.env', 'production');
    Log::spy();

    $html = (string) $this->blade('<x-jetax-button size="xl">Botão</x-jetax-button>');

    expect(tagClass(htmlTag($html, 'button')))->toContain('h-11 px-5 text-sm');
    Log::shouldHaveReceived('warning')->once();
});
