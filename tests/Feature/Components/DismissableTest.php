<?php

it('renders close button', function () {
    $view = $this->blade('<x-jetax-dismissable>Conteúdo</x-jetax-dismissable>');
    $view->assertSee('close', false);
});

it('renders slot content', function () {
    $view = $this->blade('<x-jetax-dismissable>Mensagem importante</x-jetax-dismissable>');
    $view->assertSee('Mensagem importante', false);
});

it('has persist key in alpine data', function () {
    $view = $this->blade('<x-jetax-dismissable persist-key="banner-1">Conteúdo</x-jetax-dismissable>');
    $view->assertSee('banner-1', false);
});
