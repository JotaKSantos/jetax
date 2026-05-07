<?php

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
    $mdView->assertSee('max-w-xl', false);

    $lgView = $this->blade('<x-jetax-modal id="m3" size="lg">Conteúdo</x-jetax-modal>');
    $lgView->assertSee('max-w-4xl', false);

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

it('test_high_risk_variant_classes', function () {
    $view = $this->blade('<x-jetax-modal id="modal-risk" :high-risk="true">Conteúdo de risco</x-jetax-modal>');

    $view->assertSee('border-amber-400/20', false);
    $view->assertSee('bg-amber-50', false);
    $view->assertSee('text-amber-800', false);
});

it('test_backdrop_has_blur', function () {
    $view = $this->blade('<x-jetax-modal id="modal-blur">Conteúdo</x-jetax-modal>');

    $view->assertSee('blur(4px)', false);
});
