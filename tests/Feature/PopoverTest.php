<?php

use Jetax\DesignSystem\View\Components\Popover;

it('test_hidden_by_default', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo do popover</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('x-show="open"', false);
    $view->assertSee('open: false', false);
    $view->assertSee('controlled: false', false);
    expect(htmlTag((string) $view, 'div', 'data-popover-panel'))->toContain('display: none');
});

it('test_content_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo rico do popover</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('Conteúdo rico do popover', false);
});

it('test_trigger_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Botão trigger</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('Botão trigger', false);
    $view->assertSee('popover-trigger', false);
});

it('test_has_click_trigger', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('x-on:click="toggle()"', false);
});

it('test_closes_on_click_outside', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('x-on:click.outside="if (open) { open = false; $dispatch(\'close\') }"', false);
});

it('test_closes_on_escape', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('x-on:keydown.escape.window="if (open) { open = false; $dispatch(\'close\') }"', false);
});

it('test_open_true_renders_open', function () {
    $html = (string) $this->blade(
        '<x-jetax-popover :open="true">
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    expect($html)->toContain('open: true')
        ->toContain('controlled: true')
        ->toContain('data-popover-open="true"')
        ->and(htmlTag($html, 'div', 'data-popover-panel'))->not->toContain('display: none');
});

it('test_open_false_renders_closed', function () {
    $html = (string) $this->blade(
        '<x-jetax-popover :open="false">
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    expect($html)->toContain('open: false')
        ->toContain('controlled: true')
        ->toContain('data-popover-open="false"')
        ->and(htmlTag($html, 'div', 'data-popover-panel'))->toContain('display: none');
});

it('test_controlled_mode_syncs_server_value_through_data_attribute', function () {
    $view = $this->blade(
        '<x-jetax-popover :open="false">
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee('MutationObserver', false);
    $view->assertSee("attributeFilter: ['data-popover-open']", false);
});

it('test_close_dispatches_close_event', function () {
    $view = $this->blade(
        '<x-jetax-popover :open="true" x-on:close="$wire.set(\'aberto\', null)">
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee("\$dispatch('close')", false);
    $view->assertSee('x-on:close="$wire.set(\'aberto\', null)"', false);
});

it('test_panel_is_fixed_without_teleport', function () {
    $html = (string) $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    expect(htmlTag($html, 'div', 'data-popover-panel'))->toContain('fixed')
        ->toContain('x-bind:style="menuStyle"')
        ->not->toContain('absolute')
        ->and($html)->not->toContain('x-teleport')
        ->toContain('place()');
});

it('test_open_prop_does_not_leak_as_attribute', function () {
    $html = (string) $this->blade(
        '<x-jetax-popover :open="true" position="top">
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    expect($html)->not->toContain(' open="')
        ->not->toContain('position="top"');
});

it('test_default_position_is_bottom_centered', function () {
    $view = $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    $view->assertSee("vertical: 'bottom'", false);
    $view->assertSee("horizontal: 'center'", false);
});

it('test_positions_map_to_floating_panel_direction', function (string $position, string $vertical, string $horizontal) {
    $view = $this->blade(
        '<x-jetax-popover :position="$position">
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>',
        ['position' => $position]
    );

    $view->assertSee("vertical: '{$vertical}'", false);
    $view->assertSee("horizontal: '{$horizontal}'", false);
})->with([
    ['top', 'top', 'center'],
    ['top-start', 'top', 'start'],
    ['top-end', 'top', 'end'],
    ['bottom-start', 'bottom', 'start'],
    ['bottom-end', 'bottom', 'end'],
]);

it('test_invalid_position_throws_in_testing', function () {
    new Popover(position: 'left');
})->throws(InvalidArgumentException::class);

it('test_merges_consumer_class_in_single_root_class', function () {
    $html = (string) $this->blade(
        '<x-jetax-popover class="probe-xyz">
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    preg_match('/^\s*<div\s[^>]*>/s', $html, $root);

    expect($root[0])->toContain('probe-xyz')
        ->toContain('relative inline-block')
        ->and(substr_count($root[0], 'class="'))->toBe(1);
});

it('test_uses_tokens_without_hex_or_named_palette', function () {
    $html = (string) $this->blade(
        '<x-jetax-popover>
            <button>Abrir</button>
            <x-slot:content>Conteúdo</x-slot:content>
        </x-jetax-popover>'
    );

    expect(htmlTag($html, 'div', 'data-popover-panel'))->toContain('bg-surface-container-high')
        ->toContain('border-outline-variant')
        ->and($html)->not->toMatch('/-\[#[0-9a-fA-F]+\]/')
        ->not->toContain('bg-white')
        ->not->toContain('border-t-white')
        ->not->toMatch('/-(slate|gray)-\d/');
});
