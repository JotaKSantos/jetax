<?php

it('test_items_rendered', function () {
    $view = $this->blade(
        '<x-jetax-list-group>
            <x-jetax-list-group-item title="Item Um" />
            <x-jetax-list-group-item title="Item Dois" />
            <x-jetax-list-group-item title="Item Três" />
        </x-jetax-list-group>'
    );

    $view->assertSee('Item Um');
    $view->assertSee('Item Dois');
    $view->assertSee('Item Três');
});

it('test_active_item_has_active_class', function () {
    $view = $this->blade(
        '<x-jetax-list-group>
            <x-jetax-list-group-item title="Item Ativo" :active="true" />
        </x-jetax-list-group>'
    );

    $view->assertSee('bg-primary/5', false);
});

it('test_clickable_item_has_link', function () {
    $view = $this->blade(
        '<x-jetax-list-group>
            <x-jetax-list-group-item title="Ver detalhes" href="/detalhes" />
        </x-jetax-list-group>'
    );

    $view->assertSee('<a', false);
    $view->assertSee('href="/detalhes"', false);
});
