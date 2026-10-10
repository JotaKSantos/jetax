<?php

use Illuminate\Support\Facades\Blade;

it('test_all_variants_render', function () {
    $variants = ['primary', 'info', 'success', 'warning', 'danger'];

    foreach ($variants as $variant) {
        $view = $this->blade('<x-jetax-alert message="Mensagem de teste" :variant="$variant" />', ['variant' => $variant]);

        $view->assertSee('Mensagem de teste');
    }
});

it('test_soft_style_has_light_bg', function () {
    $view = $this->blade('<x-jetax-alert message="Alerta soft" variant="primary" style="soft" />');

    $view->assertSee('bg-primary/10', false);
});

it('test_solid_style_has_full_bg', function () {
    $view = $this->blade('<x-jetax-alert message="Alerta solid" variant="primary" style="solid" />');

    $view->assertSee('bg-primary', false);
    $view->assertSee('text-white', false);
});

it('test_rich_style_has_left_border', function () {
    $view = $this->blade('<x-jetax-alert message="Alerta rich" variant="primary" style="rich" />');

    $view->assertSee('border-l-4', false);
});

it('test_dismissible_has_close_button', function () {
    $view = $this->blade('<x-jetax-alert message="Alerta dismissivel" :dismissible="true" />');

    $view->assertSee('fa-solid fa-xmark', false);
    $view->assertSee('x-on:click', false);
});

it('test_icon_accepts_brands_prefix', function () {
    $html = (string) $this->blade('<x-jetax-alert icon="brands:whatsapp" message="Mensagem" />');

    expect($html)->toContain('fa-brands fa-whatsapp')
        ->not->toContain('brands:');
});

it('test_icon_without_prefix_is_solid', function () {
    $html = (string) $this->blade('<x-jetax-alert icon="bell" message="Mensagem" />');

    expect($html)->toContain('fa-solid fa-bell');
});

it('test_icon_in_every_style_is_font_awesome', function (string $style) {
    $html = (string) $this->blade(
        "<x-jetax-alert style=\"{$style}\" icon=\"regular:bell\" message=\"Mensagem\" title=\"Título\" :dismissible=\"true\" />"
    );

    expect($html)->toContain('fa-regular fa-bell')
        ->toContain('fa-solid fa-xmark')
        ->not->toContain('regular:');
})->with(['solid', 'rich', 'soft']);

it('test_hidden_when_no_message', function () {
    $view = $this->blade('<x-jetax-alert :message="null" />');

    $view->assertDontSee('role="alert"', false);
});

it('test_soft_alert_merges_consumer_class_in_single_class_attribute', function () {
    $html = Blade::render('<x-jetax-alert variant="success" class="mb-4" message="ok" />');

    preg_match('/<div\s[^>]*role="alert"[^>]*>/s', $html, $root);

    expect(substr_count($root[0], 'class='))->toBe(1);
    expect($root[0])->toContain('mb-4')->toContain('bg-success/10');
});

it('test_solid_alert_merges_consumer_class_in_single_class_attribute', function () {
    $html = Blade::render('<x-jetax-alert variant="success" style="solid" class="mb-4" message="ok" />');

    preg_match('/<div\s[^>]*role="alert"[^>]*>/s', $html, $root);

    expect(substr_count($root[0], 'class='))->toBe(1);
    expect($root[0])->toContain('mb-4')->toContain('px-5 py-3.5 rounded-lg')->toContain('bg-success-solid');
});

it('test_rich_alert_merges_consumer_class_in_single_class_attribute', function () {
    $html = Blade::render('<x-jetax-alert variant="success" style="rich" class="mb-4" message="ok" />');

    preg_match('/<div\s[^>]*role="alert"[^>]*>/s', $html, $root);

    expect(substr_count($root[0], 'class='))->toBe(1);
    expect($root[0])->toContain('mb-4')->toContain('border-l-4')->toContain('border-success');
});

it('test_consumer_attributes_reach_root_without_leaking_props', function () {
    $html = Blade::render('<x-jetax-alert variant="info" data-x="1" wire:key="aviso" message="ok" :dismissible="true" />');

    preg_match('/<div\s[^>]*role="alert"[^>]*>/s', $html, $root);

    expect($root[0])
        ->toContain('data-x="1"')
        ->toContain('wire:key="aviso"')
        ->not->toContain('message=')
        ->not->toContain('variant=')
        ->not->toContain('dismissible=');
});

it('test_invalid_variant_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-alert variant="error" message="ok" />'))->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_alert_uses_tokens_without_hex_or_named_palette', function () {
    $root = __DIR__.'/../..';
    $sources = file_get_contents($root.'/src/View/Components/Alert.php')
        .file_get_contents($root.'/resources/views/components/alert.blade.php');

    expect($sources)->not->toMatch('/\[#[0-9a-fA-F]{3,8}\]/');
    expect($sources)->not->toMatch('/(?:bg|text|border)-(?:slate|gray|green|amber|cyan|blue|red)-\d/');
});
