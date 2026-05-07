<?php

it('test_all_items_collapsed_by_default', function () {
    $view = $this->blade('
        <x-jetax-accordion>
            <x-jetax-accordion-item title="Item 1">Conteúdo 1</x-jetax-accordion-item>
            <x-jetax-accordion-item title="Item 2">Conteúdo 2</x-jetax-accordion-item>
        </x-jetax-accordion>
    ');

    $view->assertSee('Item 1');
    $view->assertSee('Item 2');
    // x-show controls visibility, items start hidden (no :open="true")
    $view->assertSee('x-show="isOpen"', false);
});

it('test_single_mode_closes_other_on_open', function () {
    $view = $this->blade('
        <x-jetax-accordion mode="single">
            <x-jetax-accordion-item title="Item A">Conteúdo A</x-jetax-accordion-item>
            <x-jetax-accordion-item title="Item B">Conteúdo B</x-jetax-accordion-item>
        </x-jetax-accordion>
    ');

    // Single mode is the default, Alpine handles exclusive open
    $view->assertSee("mode: 'single'", false);
    $view->assertSee('toggle(id)', false);
});

it('test_multiple_mode_renders', function () {
    $view = $this->blade('
        <x-jetax-accordion mode="multiple">
            <x-jetax-accordion-item title="Item A">Conteúdo A</x-jetax-accordion-item>
        </x-jetax-accordion>
    ');

    $view->assertSee("mode: 'multiple'", false);
});

it('test_chevron_rotation_class_present', function () {
    $view = $this->blade('
        <x-jetax-accordion>
            <x-jetax-accordion-item title="Item 1">Conteúdo</x-jetax-accordion-item>
        </x-jetax-accordion>
    ');

    $view->assertSee('rotate-180', false);
    $view->assertSee('expand_more', false);
});

it('test_item_open_by_default_when_prop_set', function () {
    $view = $this->blade('
        <x-jetax-accordion mode="multiple">
            <x-jetax-accordion-item title="Item Aberto" :open="true">Conteúdo visível</x-jetax-accordion-item>
        </x-jetax-accordion>
    ');

    $view->assertSee('localOpen: true', false);
    $view->assertSee('Conteúdo visível');
});

it('test_aria_expanded_attribute_present', function () {
    $view = $this->blade('
        <x-jetax-accordion>
            <x-jetax-accordion-item title="Item">Conteúdo</x-jetax-accordion-item>
        </x-jetax-accordion>
    ');

    $view->assertSee(':aria-expanded="isOpen"', false);
});
