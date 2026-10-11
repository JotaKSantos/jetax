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
    $html = Blade::render('<x-jetax-dropdown-item href="/perfil" icon="user">Perfil</x-jetax-dropdown-item>');

    expect($html)->toContain('<a')
        ->toContain('href="/perfil"')
        ->toContain('flex items-center px-2.5 py-2 rounded-[7px] text-sm transition-colors group text-on-surface hover:bg-primary/5')
        ->not->toContain('not-enabled:')
        ->not->toContain('<button');
});

it('test_jetax_043_item_padding_and_radius_follow_mockup', function (string $template, string $tag) {
    $classes = tagClass(htmlTag(Blade::render($template), $tag));

    expect($classes)->toContain('px-2.5 py-2 rounded-[7px]')
        ->and($classes)->not->toContain('px-4')
        ->and($classes)->not->toContain('py-2.5');
})->with([
    'botão' => ['<x-jetax-dropdown-item>Editar</x-jetax-dropdown-item>', 'button'],
    'link' => ['<x-jetax-dropdown-item href="/editar">Editar</x-jetax-dropdown-item>', 'a'],
]);
