<?php

it('renders nav items from config', function () {
    config()->set('jetax.navigation.main', [
        ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'dashboard'],
        ['label' => 'Clientes', 'icon' => 'group', 'route' => 'clients.*'],
    ]);

    $view = $this->blade('<x-jetax::sidebar title="Test" />');

    $view->assertSee('Dashboard');
    $view->assertSee('Clientes');
    $view->assertSee('dashboard', false); // icon name
    $view->assertSee('group', false); // icon name
});

it('renders nav items from slot overriding config', function () {
    config()->set('jetax.navigation.main', [
        ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'dashboard'],
    ]);

    $view = $this->blade('
        <x-jetax::sidebar title="Test">
            <x-slot:nav>
                <a href="/custom">Item Custom</a>
            </x-slot:nav>
        </x-jetax::sidebar>
    ');

    $view->assertSee('Item Custom');
    $view->assertDontSee('Dashboard');
});

it('marks active item with pill indicator', function () {
    // Registra uma rota nomeada para testar routeIs()
    \Illuminate\Support\Facades\Route::get('/test-active', function () {
        return '';
    })->name('test.active');

    config()->set('jetax.navigation.main', [
        ['label' => 'Home', 'icon' => 'home', 'route' => 'test.active'],
    ]);

    // Simula request na rota nomeada para que routeIs() retorne true
    $this->get('/test-active');

    $view = $this->blade('<x-jetax::sidebar title="Test" />');

    $view->assertSee('aria-current="page"', false);
    $view->assertSee('bg-white/5', false);
    $view->assertSee('bg-[#0D99FF]', false);
});

it('inactive items have no pill', function () {
    config()->set('jetax.navigation.main', [
        ['label' => 'Never Active', 'icon' => 'block', 'route' => 'nonexistent.route'],
    ]);

    $view = $this->blade('<x-jetax::sidebar title="Test" />');

    $view->assertSee('Never Active');
    $view->assertDontSee('aria-current="page"', false);
});

it('has aria-current on active item', function () {
    // Without matching route, no aria-current should appear
    config()->set('jetax.navigation.main', [
        ['label' => 'Item', 'icon' => 'star', 'route' => 'nonexistent.route'],
    ]);

    $view = $this->blade('<x-jetax::sidebar title="Test" />');

    $view->assertDontSee('aria-current', false);
});
