<?php

it('test_has_shadow_class', function () {
    $view = $this->blade('<x-jetax-card>Conteúdo</x-jetax-card>');

    $view->assertSee('shadow-[0_4px_20px_-2px_rgba(0,0,0,0.05)]', false);
});

it('test_bordered_variant', function () {
    $view = $this->blade('<x-jetax-card :bordered="true">Conteúdo</x-jetax-card>');

    $view->assertSee('border', false);
    $view->assertSee('shadow-sm', false);
    $view->assertDontSee('shadow-[0_4px_20px', false);
});

it('test_header_has_primary_tint', function () {
    $view = $this->blade(
        '<x-jetax-card>Conteúdo<x-slot:header>Título</x-slot:header></x-jetax-card>'
    );

    $view->assertSee('bg-[#00497e]/[0.05]', false);
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
