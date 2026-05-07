<?php

it('test_container_has_fixed_positioning', function () {
    $view = $this->blade('<x-jetax-toast-container />');

    $view->assertSee('fixed', false);
    $view->assertSee('z-50', false);
    $view->assertSee('bottom-6', false);
    $view->assertSee('right-6', false);
});

it('test_toast_container_renders', function () {
    $view = $this->blade('<x-jetax-toast-container />');

    $view->assertSee('x-data', false);
    $view->assertSee('toasts', false);
    $view->assertSee('fixed', false);
});
