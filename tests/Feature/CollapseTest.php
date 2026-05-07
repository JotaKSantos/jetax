<?php

it('test_content_hidden_by_default', function () {
    $view = $this->blade('
        <x-jetax-collapse>
            <p>Conteúdo oculto</p>
        </x-jetax-collapse>
    ');

    // Default: open = false
    $view->assertSee('open: false', false);
    $view->assertSee('Conteúdo oculto');
    $view->assertSee('x-show="open"', false);
});

it('test_content_visible_when_open_true', function () {
    $view = $this->blade('
        <x-jetax-collapse :open="true">
            <p>Conteúdo visível</p>
        </x-jetax-collapse>
    ');

    $view->assertSee('open: true', false);
    $view->assertSee('Conteúdo visível');
});

it('test_trigger_slot_rendered', function () {
    $view = $this->blade('
        <x-jetax-collapse>
            <x-slot:trigger>
                <span class="custom-trigger">Clique aqui</span>
            </x-slot:trigger>
            <p>Conteúdo colapsado</p>
        </x-jetax-collapse>
    ');

    $view->assertSee('Clique aqui');
    $view->assertSee('custom-trigger', false);
});

it('test_default_trigger_when_no_slot', function () {
    $view = $this->blade('
        <x-jetax-collapse>
            <p>Conteúdo</p>
        </x-jetax-collapse>
    ');

    $view->assertSee('Mostrar conteúdo');
    $view->assertSee('expand_more', false);
});

it('test_toggle_interaction_wired', function () {
    $view = $this->blade('
        <x-jetax-collapse>
            <p>Conteúdo</p>
        </x-jetax-collapse>
    ');

    $view->assertSee('x-on:click="open = !open"', false);
});
