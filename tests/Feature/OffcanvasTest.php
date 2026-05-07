<?php

it('test_hidden_by_default', function () {
    $view = $this->blade('<x-jetax-offcanvas id="meu-offcanvas">Conteúdo</x-jetax-offcanvas>');

    $view->assertSee('x-show', false);
    $view->assertSee('open', false);
    $view->assertSee('style="display: none;"', false);
});

it('test_left_position_classes', function () {
    $view = $this->blade('<x-jetax-offcanvas id="oc-left" position="left">Conteúdo</x-jetax-offcanvas>');

    $view->assertSee('left-0', false);
    $view->assertSee('inset-y-0', false);
});

it('test_right_position_classes', function () {
    $view = $this->blade('<x-jetax-offcanvas id="oc-right" position="right">Conteúdo</x-jetax-offcanvas>');

    $view->assertSee('right-0', false);
    $view->assertSee('inset-y-0', false);
});

it('test_top_position_classes', function () {
    $view = $this->blade('<x-jetax-offcanvas id="oc-top" position="top">Conteúdo</x-jetax-offcanvas>');

    $view->assertSee('top-0', false);
    $view->assertSee('inset-x-0', false);
    $view->assertSee('h-1/3', false);
});

it('test_bottom_position_classes', function () {
    $view = $this->blade('<x-jetax-offcanvas id="oc-bottom" position="bottom">Conteúdo</x-jetax-offcanvas>');

    $view->assertSee('bottom-0', false);
    $view->assertSee('inset-x-0', false);
});

it('test_header_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-offcanvas id="oc-header"><x-slot:header>Filtros Avançados</x-slot:header>Corpo</x-jetax-offcanvas>'
    );

    $view->assertSee('Filtros Avançados');
});

it('test_default_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-offcanvas id="oc-slot">Conteúdo do painel lateral</x-jetax-offcanvas>'
    );

    $view->assertSee('Conteúdo do painel lateral');
});

it('test_aria_attributes_present', function () {
    $view = $this->blade('<x-jetax-offcanvas id="oc-aria">Conteúdo</x-jetax-offcanvas>');

    $view->assertSee('aria-modal="true"', false);
    $view->assertSee('role="dialog"', false);
});

it('test_backdrop_present', function () {
    $view = $this->blade('<x-jetax-offcanvas id="oc-backdrop">Conteúdo</x-jetax-offcanvas>');

    $view->assertSee('bg-black/40', false);
    $view->assertSee('offcanvas-backdrop', false);
});
