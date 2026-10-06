<?php

use Jetax\DesignSystem\View\Components\ButtonGroup;

/**
 * Classe do contêiner do grupo, com as entidades HTML decodificadas (`[&amp;&gt;*]` → `[&>*]`).
 */
function buttonGroupClass(string $html): string
{
    return html_entity_decode(tagClass(htmlTag($html, 'div', 'role="group"')), ENT_QUOTES);
}

function splitGroupHtml(string $attributes = ''): string
{
    return (string) test()->blade('
        <x-jetax-button-group split '.$attributes.'>
            <x-jetax-button wire:click="settle">Quitar</x-jetax-button>

            <x-jetax-dropdown position="bottom-start">
                <x-slot:trigger>
                    <x-jetax-button icon="expand_more" icon-only aria-label="Mais opções" />
                </x-slot:trigger>
                <x-jetax-dropdown-item>Quitar com crédito</x-jetax-dropdown-item>
            </x-jetax-dropdown>
        </x-jetax-button-group>
    ');
}

it('test_split_group_renders_single_inline_flex_items_stretch_container', function () {
    $html = splitGroupHtml();

    expect(substr_count($html, 'items-stretch'))->toBe(1)
        ->and(buttonGroupClass($html))->toContain('inline-flex items-stretch');
});

it('test_split_group_zeroes_inner_radius_of_children', function () {
    $container = buttonGroupClass(splitGroupHtml());

    expect($container)->toContain('[&>*]:rounded-none')
        ->toContain('[&_button]:rounded-none')
        ->toContain('rounded-xl')
        ->toContain('overflow-hidden');
});

it('test_split_group_draws_border_left_divider_between_segments', function () {
    $container = buttonGroupClass(splitGroupHtml());

    expect($container)->toContain('[&>*+*]:border-l')
        ->toContain('[&>*+*]:border-outline-variant');
});

it('test_split_group_propagates_height_to_dropdown_trigger', function () {
    $html = splitGroupHtml();

    expect(buttonGroupClass($html))->toContain('[&_button]:h-full')
        ->and(htmlTag($html, 'div', 'x-ref="trigger"'))->toContain('class="h-full"');
});

it('test_split_group_keeps_children_and_their_attributes', function () {
    $html = splitGroupHtml();

    expect($html)->toContain('wire:click="settle"')
        ->toContain('Quitar')
        ->toContain('aria-label="Mais opções"')
        ->toContain('Quitar com crédito');
});

it('test_split_group_has_single_class_root_with_consumer_class', function () {
    $root = htmlTag(splitGroupHtml('class="probe-xyz" data-account-settle-split'), 'div');

    expect(substr_count($root, 'class="'))->toBe(1)
        ->and(tagClass($root))->toContain('probe-xyz')
        ->toContain('inline-flex items-stretch')
        ->and($root)->toContain('data-account-settle-split');
});

it('test_split_group_uses_tokens_without_named_palette_or_hex', function () {
    $html = splitGroupHtml();
    $container = htmlTag($html, 'div', 'role="group"');

    expect($container)->not->toContain('bg-white')
        ->not->toContain('slate-')
        ->not->toContain('gray-')
        ->not->toContain('[#');
});

it('test_group_without_split_keeps_children_radius', function () {
    $html = (string) $this->blade('
        <x-jetax-button-group>
            <x-jetax-button>Um</x-jetax-button>
            <x-jetax-button>Dois</x-jetax-button>
        </x-jetax-button-group>
    ');

    $container = buttonGroupClass($html);

    expect($container)->toBe(ButtonGroup::GROUP_CLASSES)
        ->not->toContain('rounded-none')
        ->not->toContain('border-l');
});
