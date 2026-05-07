<?php

it('test_hidden_by_default', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo do popover</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('x-show', false);
    $view->assertSee('open', false);
    $view->assertSee('display: none', false);
});

it('test_content_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo rico do popover</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('Conteúdo rico do popover', false);
});

it('test_trigger_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Botão trigger</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('Botão trigger', false);
    $view->assertSee('popover-trigger', false);
});

it('test_has_click_trigger', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('@click', false);
});

it('test_closes_on_click_outside', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('click.outside', false);
});

it('test_closes_on_escape', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('keydown.escape', false);
});

it('test_default_position_is_bottom', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('top-full', false);
    $view->assertSee('mt-2', false);
});

it('test_arrow_present', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('popover-arrow', false);
});
