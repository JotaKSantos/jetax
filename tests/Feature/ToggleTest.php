<?php

use Illuminate\Support\Facades\Blade;

it('test_renders_toggle_with_alpine_state', function () {
    $view = $this->blade('<x-jetax-toggle />');

    $view->assertSee('x-data', false);
});

it('test_label_rendered', function () {
    $view = $this->blade('<x-jetax-toggle label="Ativar notificações" />');

    $view->assertSee('Ativar notificações');
});

it('test_initial_state_off_by_default', function () {
    $view = $this->blade('<x-jetax-toggle />');

    $view->assertSee('localOn: false', false);
});

it('test_wire_model_writes_through_wire_set', function () {
    $html = Blade::render('<x-jetax-toggle name="ativo" wire:model="ativo" />');

    expect($html)
        ->toContain('$wire')
        ->toContain('$set(')
        ->toContain('$wire.$set(this.wireProperty, value, this.wireIsLive);')
        ->toContain("wireProperty: 'ativo'")
        ->not->toContain('wire:model');
});

it('test_wire_model_reads_nested_path_through_wire_get', function () {
    $html = Blade::render('<x-jetax-toggle name="contacts.2.consented" wire:model="contacts.2.consented" />');

    expect($html)
        ->toContain('$wire.get(this.wireProperty)')
        ->toContain("wireProperty: 'contacts.2.consented'")
        ->not->toContain('$wire[')
        ->not->toContain('wire:model');
});

it('test_live_modifier_controls_round_trip', function () {
    $deferred = Blade::render('<x-jetax-toggle name="ativo" wire:model="ativo" />');
    $live = Blade::render('<x-jetax-toggle name="ativo" wire:model.live="ativo" />');
    $liveDebounced = Blade::render('<x-jetax-toggle name="ativo" wire:model.live.debounce.300ms="ativo" />');

    expect($deferred)->toContain('wireIsLive: false');
    expect($live)->toContain('wireIsLive: true')->toContain("wireProperty: 'ativo'");
    expect($liveDebounced)->toContain('wireIsLive: true');
});

it('test_no_wire_model_attribute_leaks', function (string $directive) {
    $html = Blade::render("<x-jetax-toggle name=\"ativo\" {$directive}=\"ativo\" />");

    expect($html)
        ->toContain('$wire')
        ->toContain('$set(')
        ->toContain("wireProperty: 'ativo'")
        ->not->toContain('wire:model');
})->with([
    'wire:model',
    'wire:model.live',
    'wire:model.debounce.500ms',
    'wire:model.live.debounce.300ms',
]);

it('test_without_wire_model_keeps_local_state_and_hidden_input', function () {
    $on = Blade::render('<x-jetax-toggle name="x" :checked="true" />');
    $off = Blade::render('<x-jetax-toggle name="x" />');

    expect($on)
        ->toContain('wireProperty: null')
        ->toContain('localOn: true')
        ->toContain('name="x"')
        ->toContain(':value="on ? \'1\' : \'0\'"')
        ->not->toContain('wire:model');

    expect($off)->toContain('localOn: false');
});

it('test_state_is_a_getter_over_wire', function () {
    $html = Blade::render('<x-jetax-toggle name="ativo" wire:model="ativo" />');

    expect($html)
        ->toContain('get on() {')
        ->toContain('return this.wireProperty ? !! $wire.get(this.wireProperty) : this.localOn;')
        ->toContain('set on(value) {')
        ->toContain('x-effect=');
});

it('test_track_and_knob_follow_mockup_colors', function () {
    $html = Blade::render('<x-jetax-toggle name="ativo" label="Ativo" />');

    expect($html)
        ->toContain(":class=\"on ? 'bg-success' : 'bg-outline'\"")
        ->toContain('focus:ring-primary')
        ->not->toContain('bg-[#')
        ->not->toContain('bg-on-surface-variant');

    preg_match('/<span\s[^>]*translate-x[^>]*>/s', $html, $knob);

    expect($knob[0] ?? '')->toContain('bg-on-primary');
});

it('test_label_uses_on_surface_token', function () {
    $html = Blade::render('<x-jetax-toggle name="ativo" label="Ativo" />');

    preg_match('/<label\s[^>]*>/s', $html, $label);

    expect($label[0] ?? '')->toContain('text-on-surface');
    expect($html)->not->toContain('text-[#');
});

it('test_id_is_deterministic_from_name', function () {
    $first = Blade::render('<x-jetax-toggle name="ativo" label="Ativo" />');
    $second = Blade::render('<x-jetax-toggle name="ativo" label="Ativo" />');

    expect($first)
        ->toContain('id="toggle_ativo"')
        ->toContain('for="toggle_ativo"')
        ->and($second)->toContain('id="toggle_ativo"');
});

it('test_toggle_has_no_hex_or_named_palette', function () {
    $template = file_get_contents(__DIR__.'/../../resources/views/components/toggle.blade.php');

    expect($template)->not->toMatch('/#[0-9a-fA-F]{3,8}\b/');
    expect($template)->not->toMatch('/(?:bg|text|border|ring)-(?:slate|gray|zinc|red|green|amber|blue)-\d/');
});
