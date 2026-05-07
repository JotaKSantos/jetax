<?php

it('has fixed positioning classes', function () {
    $view = $this->blade('<x-jetax::topbar title="Test" />');

    $view->assertSee('fixed', false);
    $view->assertSee('top-0', false);
    $view->assertSee('z-40', false);
});

it('has glassmorphism classes', function () {
    $view = $this->blade('<x-jetax::topbar title="Test" />');

    $view->assertSee('backdrop-blur-xl', false);
    $view->assertSee('bg-white/80', false);
});

it('renders actions slot', function () {
    $view = $this->blade('
        <x-jetax::topbar title="Test">
            <x-slot:actions>
                <button>Ação</button>
            </x-slot:actions>
        </x-jetax::topbar>
    ');

    $view->assertSee('Ação');
});

it('has hamburger button', function () {
    $view = $this->blade('<x-jetax::topbar />');

    $view->assertSee('Alternar menu');
});

it('has search bar', function () {
    $view = $this->blade('<x-jetax::topbar />');

    $view->assertSee('Pesquisar', false);
});
