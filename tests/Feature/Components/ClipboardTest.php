<?php

it('renders trigger button', function () {
    $view = $this->blade('<x-jetax-clipboard text="hello" />');
    $view->assertSee('content_copy', false);
});

it('has text prop in alpine data', function () {
    $view = $this->blade('<x-jetax-clipboard text="copy-me" />');
    $view->assertSee('copy-me', false);
});

it('has check icon in html hidden by default', function () {
    $view = $this->blade('<x-jetax-clipboard text="hello" />');
    $view->assertSee('check', false);
});
