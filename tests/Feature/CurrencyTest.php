<?php

use Illuminate\Support\Facades\Blade;

it('test_currency_symbol_rendered', function () {
    $view = $this->blade('<x-jetax-currency name="preco" />');

    $view->assertSee('R$');
});

it('test_wire_model_receives_raw_number', function () {
    $view = $this->blade('<x-jetax-currency name="preco" wire:model="preco" />');

    $view->assertSee('x-data', false);
    $view->assertSee('rawValue', false);
});

it('test_error_class_applied', function () {
    $view = $this->withViewErrors(['preco' => 'O campo preço é obrigatório'])
        ->blade('<x-jetax-currency name="preco" />');

    $view->assertSee('border-error', false);
    $view->assertSee('text-error', false);
    $view->assertDontSee('border-red-500', false);
});

it('test_wire_model_writes_raw_string_through_wire_set', function () {
    $html = Blade::render('<x-jetax-currency name="valor" wire:model="valor" />');

    expect($html)
        ->toContain('$wire.$set(')
        ->toContain('String(this.rawValue)')
        ->toContain('pushToWire()')
        ->toContain("wireProperty: 'valor'")
        ->toContain('x-effect')
        ->not->toContain('wire:model');
});

it('test_wire_model_reads_through_wire_get', function () {
    $html = Blade::render('<x-jetax-currency name="form.valor" wire:model="form.valor" />');

    expect($html)
        ->toContain('$wire.get(this.wireProperty)')
        ->toContain("wireProperty: 'form.valor'")
        ->not->toContain('$wire[');
});

it('test_live_modifier_controls_round_trip', function () {
    $deferred = Blade::render('<x-jetax-currency name="valor" wire:model="valor" />');
    $live = Blade::render('<x-jetax-currency name="valor" wire:model.live="valor" />');
    $blur = Blade::render('<x-jetax-currency name="valor" wire:model.blur="valor" />');

    expect($deferred)->toContain('wireIsLive: false');
    expect($live)->toContain('wireIsLive: true');
    expect($blur)->toContain('wireIsLive: false')->toContain("wireProperty: 'valor'");
});

it('test_x_effect_syncs_value_from_server', function () {
    $html = Blade::render('<x-jetax-currency name="valor" wire:model.live="valor" />');

    expect($html)
        ->toContain('x-effect="syncFromWire()"')
        ->toContain('syncFromWire() {');
});

it('test_no_wire_model_attribute_leaks', function (string $directive) {
    $html = Blade::render("<x-jetax-currency name=\"valor\" {$directive}=\"valor\" />");

    expect($html)
        ->toContain('$wire.$set(')
        ->toContain("wireProperty: 'valor'")
        ->not->toContain('wire:model');
})->with([
    'wire:model',
    'wire:model.live',
    'wire:model.blur',
    'wire:model.lazy',
    'wire:model.live.debounce.500ms',
]);

it('test_hidden_input_only_without_wire_model', function () {
    $plain = Blade::render('<x-jetax-currency name="valor" />');
    $bound = Blade::render('<x-jetax-currency name="valor" wire:model="valor" />');

    expect($plain)
        ->toContain('wireProperty: null')
        ->toContain('<input type="hidden" name="valor" x-bind:value="rawValue"')
        ->not->toContain('wire:model');

    expect($bound)->not->toContain('type="hidden"');
});

it('test_id_is_deterministic_from_name', function () {
    $first = Blade::render('<x-jetax-currency name="valor" label="Valor" />');
    $second = Blade::render('<x-jetax-currency name="valor" label="Valor" />');

    expect($first)
        ->toContain('id="currency_valor"')
        ->toContain('for="currency_valor"')
        ->and($second)->toContain('id="currency_valor"');
});

it('test_currency_symbol_uses_tokens', function () {
    $html = Blade::render('<x-jetax-currency name="valor" />');

    preg_match('/<span\s+data-currency-symbol[^>]*>/s', $html, $symbol);

    expect($symbol[0] ?? '')
        ->toContain('text-on-surface-variant')
        ->toContain('text-[11px]')
        ->toContain('font-bold')
        ->toContain('tracking-[.06em]')
        ->not->toContain('text-[#')
        ->not->toContain('border-[#');
});

it('test_label_uses_on_surface_variant_token_and_metric', function () {
    $html = Blade::render('<x-jetax-currency name="valor" label="Desconto" />');

    preg_match('/<label\s[^>]*>/s', $html, $label);

    expect($label[0] ?? '')
        ->toContain('text-on-surface-variant')
        ->toContain('text-[11px]')
        ->toContain('font-bold')
        ->toContain('tracking-[.06em]');

    expect($html)->toContain('Desconto')->not->toContain('text-[#');
});

it('test_currency_has_no_hex_or_named_palette', function () {
    $root = __DIR__.'/../..';
    $sources = file_get_contents($root.'/resources/views/components/currency.blade.php')
        .file_get_contents($root.'/src/View/Components/Currency.php');

    expect($sources)->not->toMatch('/\[#[0-9a-fA-F]{3,8}\]/');
    expect($sources)->not->toMatch('/(?:bg|text|border|ring)-(?:slate|gray|zinc|red|green|amber|blue)-\d/');
    expect($sources)->not->toContain('bg-white');
});
