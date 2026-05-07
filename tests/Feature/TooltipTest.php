<?php

it('test_content_in_html', function () {
    $view = $this->blade('<x-jetax-tooltip content="Texto do tooltip">Hover aqui</x-jetax-tooltip>');

    $view->assertSee('Texto do tooltip', false);
});

it('test_trigger_wraps_slot', function () {
    $view = $this->blade('<x-jetax-tooltip content="Dica"><button>Botão</button></x-jetax-tooltip>');

    $view->assertSee('tooltip-trigger', false);
    $view->assertSee('Botão', false);
});

it('test_default_position_is_top', function () {
    $view = $this->blade('<x-jetax-tooltip content="Dica">Trigger</x-jetax-tooltip>');

    $view->assertSee('bottom-full', false);
    $view->assertSee('mb-2', false);
});

it('test_bottom_position_classes', function () {
    $view = $this->blade('<x-jetax-tooltip content="Dica" position="bottom">Trigger</x-jetax-tooltip>');

    $view->assertSee('top-full', false);
    $view->assertSee('mt-2', false);
});

it('test_left_position_classes', function () {
    $view = $this->blade('<x-jetax-tooltip content="Dica" position="left">Trigger</x-jetax-tooltip>');

    $view->assertSee('right-full', false);
    $view->assertSee('mr-2', false);
});

it('test_right_position_classes', function () {
    $view = $this->blade('<x-jetax-tooltip content="Dica" position="right">Trigger</x-jetax-tooltip>');

    $view->assertSee('left-full', false);
    $view->assertSee('ml-2', false);
});

it('test_tooltip_hidden_by_default', function () {
    $view = $this->blade('<x-jetax-tooltip content="Dica">Trigger</x-jetax-tooltip>');

    $view->assertSee('x-show', false);
    $view->assertSee('show', false);
});

it('test_has_alpine_hover_trigger', function () {
    $view = $this->blade('<x-jetax-tooltip content="Dica">Trigger</x-jetax-tooltip>');

    $view->assertSee('mouseenter', false);
    $view->assertSee('mouseleave', false);
});
