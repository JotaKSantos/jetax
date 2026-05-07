<?php

it('renders fixed button', function () {
    $view = $this->blade('<x-jetax-back-to-top />');
    $view->assertSee('fixed', false);
});

it('is hidden by default via x-show', function () {
    $view = $this->blade('<x-jetax-back-to-top />');
    $view->assertSee('x-show', false);
});
