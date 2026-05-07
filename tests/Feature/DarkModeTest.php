<?php

it('has dark class strategy configured in preset', function () {
    $presetPath = realpath(__DIR__ . '/../../resources/js/jetax-preset.js');
    $content = file_get_contents($presetPath);

    expect($content)->toContain("darkMode: 'class'");
});

it('has inline script that prevents flash in layout', function () {
    $view = $this->blade('<x-jetax-layout title="Test">Content</x-jetax-layout>');

    $view->assertSee("localStorage.getItem('jetax-theme')", false);
    $view->assertSee("classList.add('dark')", false);
});

it('has inline script that prevents flash in auth layout', function () {
    $view = $this->blade('<x-jetax-auth-layout title="Test">Content</x-jetax-auth-layout>');

    $view->assertSee("localStorage.getItem('jetax-theme')", false);
    $view->assertSee("classList.add('dark')", false);
});

it('toggle component renders sun and moon icons', function () {
    $view = $this->blade('<x-jetax::dark-mode-toggle />');

    $view->assertSee('light_mode', false);
    $view->assertSee('dark_mode', false);
    $view->assertSee('jetax-dark-mode-toggle', false);
});

it('toggle has alpine data binding', function () {
    $view = $this->blade('<x-jetax::dark-mode-toggle />');

    $view->assertSee('x-data="jetaxDarkMode()"', false);
    $view->assertSee('@click="toggle()"', false);
});

it('toggle stores preference in localStorage', function () {
    // O script fica em @push('jetax-scripts'), precisa do @stack para renderizar
    $view = $this->blade('
        <x-jetax-layout title="Test">
            <x-jetax::dark-mode-toggle />
        </x-jetax-layout>
    ');

    $view->assertSee("localStorage.setItem('jetax-theme'", false);
});
