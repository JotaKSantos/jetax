<?php

use Illuminate\Support\Facades\Blade;

it('test_renders_label_prop_without_alpine_state', function () {
    $html = (string) $this->blade('<x-jetax-chip label="Situação: Quitado" />');

    expect($html)->toContain('Situação: Quitado')
        ->not->toContain('x-data')
        ->not->toContain('<button');
});

it('test_renders_label_from_default_slot', function () {
    $html = (string) $this->blade('<x-jetax-chip>Espécie: Canina</x-jetax-chip>');

    expect($html)->toContain('Espécie: Canina');
});

it('test_removable_sends_wire_click_to_remove_button', function () {
    $html = (string) $this->blade('<x-jetax-chip label="Situação: Quitado" removable wire:click="remover" />');

    $button = htmlTag($html, 'button');
    $root = htmlTag($html, 'span');

    expect($html)->not->toContain('x-data')
        ->and($button)->toContain('wire:click="remover"')
        ->toContain('type="button"')
        ->toContain('aria-label="Remover"')
        ->and($root)->not->toContain('wire:click')
        ->and($html)->toContain('>close</span></button>');
});

it('test_remove_prefixed_attributes_reach_button_without_prefix', function () {
    $html = (string) $this->blade(
        '<x-jetax-chip label="Período: Hoje" removable wire:click="removeFilter(\'periodo\')" remove:data-filter="periodo" remove-label="Remover filtro" data-chip="periodo" />'
    );

    $button = htmlTag($html, 'button');
    $root = htmlTag($html, 'span');

    expect($button)->toContain('data-filter="periodo"')
        ->toContain('aria-label="Remover filtro"')
        ->toContain('wire:click="removeFilter(\'periodo\')"')
        ->not->toContain('remove:')
        ->and($root)->toContain('data-chip="periodo"')
        ->not->toContain('data-filter')
        ->not->toContain('remove-label');
});

it('test_alpine_click_attributes_reach_button', function () {
    $html = (string) $this->blade('<x-jetax-chip label="Tag" removable x-on:click="remove(1)" />');

    expect(htmlTag($html, 'button'))->toContain('x-on:click="remove(1)"')
        ->and(htmlTag($html, 'span'))->not->toContain('x-on:click');
});

it('test_without_removable_click_attributes_stay_on_root', function () {
    $html = (string) $this->blade('<x-jetax-chip label="Tag" wire:click="abrir" />');

    expect(htmlTag($html, 'span'))->toContain('wire:click="abrir"')
        ->and($html)->not->toContain('<button');
});

it('test_merges_consumer_class_in_single_root_class', function () {
    $html = (string) $this->blade('<x-jetax-chip label="Tag" removable class="probe-xyz" />');

    $root = htmlTag($html, 'span');

    expect($root)->toContain('probe-xyz')
        ->toContain('inline-flex')
        ->and(substr_count($root, 'class="'))->toBe(1);
});

it('test_uses_tokens_without_hex_or_named_palette', function () {
    $html = (string) $this->blade('<x-jetax-chip label="Tag" removable />');

    expect($html)->toContain('text-primary')
        ->not->toMatch('/-\[#[0-9a-fA-F]+\]/')
        ->not->toContain('bg-white')
        ->not->toMatch('/-(slate|gray)-\d/');
});

it('test_chip_is_registered', function () {
    expect(Blade::getClassComponentAliases())->toHaveKey('jetax-chip');
});
