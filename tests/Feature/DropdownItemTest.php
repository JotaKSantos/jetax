<?php

use Illuminate\Support\Facades\Blade;

it('test_disabled_item_is_dimmed_blocked_and_without_hover', function () {
    $html = Blade::render('<x-jetax-dropdown-item disabled>Excluir</x-jetax-dropdown-item>');

    preg_match('/<button[^>]*>/', $html, $matches);

    expect($matches[0] ?? '')->toContain('not-enabled:opacity-40')
        ->toContain('not-enabled:cursor-not-allowed')
        ->toContain('not-enabled:hover:bg-transparent')
        ->toContain('disabled');
});

it('test_enabled_item_html_has_no_disabled_substring', function () {
    $html = Blade::render('<x-jetax-dropdown-item>Editar</x-jetax-dropdown-item>');

    expect($html)->not->toContain('disabled');
});

it('test_link_item_keeps_package_markup', function () {
    $html = Blade::render('<x-jetax-dropdown-item href="/perfil" icon="person">Perfil</x-jetax-dropdown-item>');

    expect($html)->toContain('<a')
        ->toContain('href="/perfil"')
        ->toContain('flex items-center px-4 py-2.5 text-sm transition-colors group text-on-surface hover:bg-primary/5')
        ->not->toContain('not-enabled:')
        ->not->toContain('<button');
});
