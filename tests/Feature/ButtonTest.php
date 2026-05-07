<?php

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
