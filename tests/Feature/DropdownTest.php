<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Jetax\DesignSystem\View\Components\Dropdown;

it('test_menu_hidden_by_default', function () {
    $view = $this->blade('
        <x-jetax-dropdown>
            <x-slot:trigger>
                <button>Abrir</button>
            </x-slot:trigger>
            <x-jetax-dropdown-item>Item 1</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    ');

    $view->assertSee('x-show', false);
});

it('test_trigger_slot_rendered', function () {
    $view = $this->blade('
        <x-jetax-dropdown>
            <x-slot:trigger>
                <button>Menu</button>
            </x-slot:trigger>
            <x-jetax-dropdown-item>Item 1</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    ');

    $view->assertSee('Menu', false);
});

it('test_items_slot_rendered', function () {
    $view = $this->blade('
        <x-jetax-dropdown>
            <x-slot:trigger>
                <button>Abrir</button>
            </x-slot:trigger>
            <x-jetax-dropdown-item>Meu perfil</x-jetax-dropdown-item>
            <x-jetax-dropdown-item>Preferências</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    ');

    $view->assertSee('Meu perfil', false);
    $view->assertSee('Preferências', false);
});

it('test_destructive_item_has_danger_class', function () {
    $view = $this->blade('
        <x-jetax-dropdown>
            <x-slot:trigger>
                <button>Abrir</button>
            </x-slot:trigger>
            <x-jetax-dropdown-item :destructive="true">Excluir</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    ');

    $view->assertSee('text-error', false);
});

function renderDropdown(string $attributes = ''): string
{
    return Blade::render('
        <x-jetax-dropdown '.$attributes.'>
            <x-slot:trigger>
                <button>Abrir</button>
            </x-slot:trigger>
            <x-jetax-dropdown-item>Item 1</x-jetax-dropdown-item>
        </x-jetax-dropdown>
    ');
}

function dropdownMenuTag(string $html): string
{
    preg_match('/<div\s+x-ref="menu"[^>]*>/', $html, $matches);

    return $matches[0] ?? '';
}

it('test_positions_constant_lists_the_four_positions', function () {
    expect(Dropdown::POSITIONS)->toBe(['bottom-start', 'bottom-end', 'top-start', 'top-end']);
});

it('test_menu_is_fixed_and_placed_from_trigger_rect', function () {
    $html = renderDropdown();
    $menu = dropdownMenuTag($html);

    expect($menu)->not->toBe('')
        ->and($menu)->toMatch('/class="[^"]*\bfixed\b/')
        ->and($menu)->toContain('x-bind:style="menuStyle"')
        ->and($html)->toContain('getBoundingClientRect()');
});

it('test_menu_is_not_teleported', function () {
    expect(renderDropdown())->not->toContain('x-teleport');
});

it('test_each_position_emits_vertical_and_horizontal_direction', function (string $position, string $vertical, string $horizontal) {
    $html = renderDropdown('position="'.$position.'"');

    expect($html)->toContain("vertical: '{$vertical}'")
        ->and($html)->toContain("horizontal: '{$horizontal}'");
})->with([
    'bottom-start' => ['bottom-start', 'bottom', 'start'],
    'bottom-end' => ['bottom-end', 'bottom', 'end'],
    'top-start' => ['top-start', 'top', 'start'],
    'top-end' => ['top-end', 'top', 'end'],
]);

it('test_default_position_is_bottom_start', function () {
    $html = renderDropdown();

    expect($html)->toContain("vertical: 'bottom'")
        ->and($html)->toContain("horizontal: 'start'");
});

it('test_invalid_position_throws_in_testing', function () {
    expect(fn () => new Dropdown(position: 'left'))->toThrow(InvalidArgumentException::class, '"left"');
});

it('test_invalid_position_falls_back_in_production', function () {
    config(['app.env' => 'production']);
    Log::spy();

    expect((new Dropdown(position: 'left'))->position)->toBe('bottom-start');

    Log::shouldHaveReceived('warning')->once();
});

it('test_menu_flips_when_it_does_not_fit', function () {
    $html = renderDropdown();

    expect($html)->toContain('top + height > window.innerHeight && rect.top - height - gap >= 0')
        ->and($html)->toContain('top < 0 && rect.bottom + gap + height <= window.innerHeight');
});

it('test_menu_repositions_on_scroll_and_resize', function () {
    $html = renderDropdown();

    expect($html)->toContain('x-on:scroll.window.passive="open && place()"')
        ->and($html)->toContain('x-on:resize.window="open && place()"');
});

it('test_outside_click_ignores_menu_and_menu_click_closes', function () {
    $html = renderDropdown();

    expect($html)->toContain('x-on:click.outside="if (! $refs.menu?.contains($event.target)) open = false"')
        ->and(dropdownMenuTag($html))->toContain('x-on:click="open = false"');
});

it('test_trigger_wrapper_fills_stretched_parent_height', function () {
    expect(renderDropdown())->toMatch('/<div x-ref="trigger"[^>]*class="h-full"/');
});

it('test_menu_width_follows_content_within_bounds', function () {
    $menu = dropdownMenuTag(renderDropdown());

    expect($menu)->toContain('min-w-[12rem] w-max max-w-[20rem]')
        ->and($menu)->not->toContain('w-56');
});

it('test_menu_position_classes_method_was_removed', function () {
    expect(method_exists(Dropdown::class, 'menuPositionClasses'))->toBeFalse();
});

it('test_root_merges_consumer_class', function () {
    expect(renderDropdown('class="probe-xyz"'))->toContain('class="relative inline-block probe-xyz"');
});
