<?php

it('test_has_shadow_class', function () {
    $view = $this->blade('<x-jetax-card>Conteúdo</x-jetax-card>');

    $view->assertSee('shadow-[#111A37]/5', false);
});

it('test_default_uses_white_in_light_dark_in_dark', function () {
    $view = $this->blade('<x-jetax-card>Conteúdo</x-jetax-card>');

    $view->assertSee('bg-white', false);
    $view->assertSee('dark:bg-[#161B2A]', false);
});

it('test_dark_mode_has_subtle_border', function () {
    $view = $this->blade('<x-jetax-card>Conteúdo</x-jetax-card>');

    $view->assertSee('dark:border-white/[0.05]', false);
});

it('test_bordered_variant', function () {
    $view = $this->blade('<x-jetax-card :bordered="true">Conteúdo</x-jetax-card>');

    $view->assertSee('border', false);
    $view->assertSee('shadow-sm', false);
    $view->assertDontSee('shadow-[0_4px_20px', false);
});

it('test_header_uses_secondary_in_light_and_primary_in_dark', function () {
    $view = $this->blade(
        '<x-jetax-card>Conteúdo<x-slot:header>Título</x-slot:header></x-jetax-card>'
    );

    $view->assertSee('bg-secondary/5', false);
    $view->assertSee('dark:bg-primary/5', false);
});

it('test_footer_uses_surface_container_low', function () {
    $view = $this->blade(
        '<x-jetax-card>Conteúdo<x-slot:footer>Rodapé</x-slot:footer></x-jetax-card>'
    );

    $view->assertSee('bg-surface-container-low', false);
});

it('test_featured_variant', function () {
    $view = $this->blade('<x-jetax-card :featured="true">Conteúdo</x-jetax-card>');

    $view->assertSee('border-t-4', false);
    $view->assertSee('border-error', false);
});

it('test_header_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-card>Corpo<x-slot:header>Título do Card</x-slot:header></x-jetax-card>'
    );

    $view->assertSee('Título do Card');
});

it('test_footer_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-card>Corpo<x-slot:footer>Rodapé do Card</x-slot:footer></x-jetax-card>'
    );

    $view->assertSee('Rodapé do Card');
});

it('test_header_class_prop_appended', function () {
    $view = $this->blade(
        '<x-jetax-card header-class="custom-header-x">Corpo<x-slot:header>Título</x-slot:header></x-jetax-card>'
    );

    $view->assertSee('custom-header-x', false);
    $view->assertSee('bg-secondary/5', false);
});

it('test_footer_class_prop_appended', function () {
    $view = $this->blade(
        '<x-jetax-card footer-class="custom-footer-y">Corpo<x-slot:footer>Rodapé</x-slot:footer></x-jetax-card>'
    );

    $view->assertSee('custom-footer-y', false);
    $view->assertSee('bg-surface-container-low', false);
});
