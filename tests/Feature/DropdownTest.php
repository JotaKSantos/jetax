<?php

it('test_menu_hidden_by_default', function () {
    $view = $this->blade('
        <x-jetax-dropdown>
            <x-slot:trigger>
                <button>Abrir</button>
            </x-slot:trigger>
            <x-jetax-dropdown-item>Item 1</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    ');

    $view->assertSee('x-show', false);
});

it('test_trigger_slot_rendered', function () {
    $view = $this->blade('
        <x-jetax-dropdown>
            <x-slot:trigger>
                <button>Menu</button>
            </x-slot:trigger>
            <x-jetax-dropdown-item>Item 1</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    ');

    $view->assertSee('Menu', false);
});

it('test_items_slot_rendered', function () {
    $view = $this->blade('
        <x-jetax-dropdown>
            <x-slot:trigger>
                <button>Abrir</button>
            </x-slot:trigger>
            <x-jetax-dropdown-item>Meu perfil</x-jetax-dropdown-item>
            <x-jetax-dropdown-item>Preferências</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    ');

    $view->assertSee('Meu perfil', false);
    $view->assertSee('Preferências', false);
});

it('test_destructive_item_has_danger_class', function () {
    $view = $this->blade('
        <x-jetax-dropdown>
            <x-slot:trigger>
                <button>Abrir</button>
            </x-slot:trigger>
            <x-jetax-dropdown-item :destructive="true">Excluir</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    ');

    $view->assertSee('text-error', false);
});
