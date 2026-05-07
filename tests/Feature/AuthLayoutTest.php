<?php

use Jetax\DesignSystem\View\Components\AuthLayout;

it('renders without sidebar and topbar', function () {
    $view = $this->blade('<x-jetax-auth-layout title="Login">Form</x-jetax-auth-layout>');

    $view->assertDontSee('jetax-sidebar', false);
    $view->assertDontSee('jetax-topbar', false);
    $view->assertSee('jetax-auth-layout', false);
});

it('renders title and subtitle', function () {
    $view = $this->blade('<x-jetax-auth-layout title="Entrar" subtitle="Acesse sua conta">Form</x-jetax-auth-layout>');

    $view->assertSee('Entrar');
    $view->assertSee('Acesse sua conta');
});

it('renders slot content in form area', function () {
    $view = $this->blade('
        <x-jetax-auth-layout title="Login">
            <form>
                <input type="email" name="email" />
                <button type="submit">Entrar</button>
            </form>
        </x-jetax-auth-layout>
    ');

    $view->assertSee('jetax-auth-form', false);
    $view->assertSee('type="email"', false);
    $view->assertSee('Entrar');
});

it('has two panel layout structure', function () {
    $view = $this->blade('<x-jetax-auth-layout title="Login">Form</x-jetax-auth-layout>');

    $view->assertSee('lg:w-[58%]', false); // left panel
    $view->assertSee('bg-[#202947]', false); // branding bg
    $view->assertSee('max-w-[440px]', false); // form container
});
