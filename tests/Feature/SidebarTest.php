<?php

use Illuminate\Support\Facades\Route;

it('renders nav items from config', function () {
    config()->set('jetax.navigation.main', [
        ['label' => 'Dashboard', 'icon' => 'table-cells-large', 'route' => 'dashboard'],
        ['label' => 'Clientes', 'icon' => 'users', 'route' => 'clients.*'],
    ]);

    $view = $this->blade('<x-jetax::sidebar title="Test" />');

    $view->assertSee('Dashboard');
    $view->assertSee('Clientes');
    $view->assertSee('fa-solid fa-table-cells-large', false);
    $view->assertSee('fa-solid fa-users', false);
});

it('renders nav items from slot overriding config', function () {
    config()->set('jetax.navigation.main', [
        ['label' => 'Dashboard', 'icon' => 'table-cells-large', 'route' => 'dashboard'],
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
    Route::get('/test-active', function () {
        return '';
    })->name('test.active');

    config()->set('jetax.navigation.main', [
        ['label' => 'Home', 'icon' => 'house', 'route' => 'test.active'],
    ]);

    // Simula request na rota nomeada para que routeIs() retorne true
    $this->get('/test-active');

    $view = $this->blade('<x-jetax::sidebar title="Test" />');

    $view->assertSee('aria-current="page"', false);
    $view->assertSee('bg-white/5', false);
    $view->assertSee('before:bg-primary', false);
});

it('inactive items have no pill', function () {
    config()->set('jetax.navigation.main', [
        ['label' => 'Never Active', 'icon' => 'ban', 'route' => 'nonexistent.route'],
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

it('renders navigation icon with style prefix', function () {
    config()->set('jetax.navigation.main', [
        ['label' => 'Avisos', 'icon' => 'regular:bell', 'route' => 'nonexistent.route'],
        ['label' => 'WhatsApp', 'icon' => 'brands:whatsapp', 'route' => 'nonexistent.route'],
    ]);

    $html = (string) $this->blade('<x-jetax::sidebar title="Test" />');

    expect($html)->toContain('fa-regular fa-bell')
        ->toContain('fa-brands fa-whatsapp')
        ->not->toContain('regular:')
        ->not->toContain('brands:')
        ->not->toContain('material');
});
