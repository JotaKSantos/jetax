<?php

use Jetax\DesignSystem\View\Components\Layout;

it('renders sidebar, topbar, and workspace', function () {
    $view = $this->blade('<x-jetax-layout title="Test">Content</x-jetax-layout>');

    $view->assertSee('jetax-sidebar', false);
    $view->assertSee('jetax-topbar', false);
    $view->assertSee('jetax-workspace', false);
});

it('sets the title in the head', function () {
    $view = $this->blade('<x-jetax-layout title="Minha Página">Content</x-jetax-layout>');

    $view->assertSee('<title>Minha Página</title>', false);
});

it('renders slot content in workspace', function () {
    $view = $this->blade('<x-jetax-layout title="Test">Conteúdo do workspace</x-jetax-layout>');

    $view->assertSee('Conteúdo do workspace');
});
