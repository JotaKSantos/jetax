<?php

use Illuminate\Support\Facades\Blade;

it('test_renders_checkbox_input', function () {
    $view = $this->blade('<x-jetax-checkbox />');

    $view->assertSee('type="checkbox"', false);
    $view->assertSee('<input', false);
});

it('test_label_is_associated', function () {
    $view = $this->blade('<x-jetax-checkbox label="Aceito os termos" name="termos" />');

    $rendered = (string) $view;

    preg_match('/id="([^"]+)"/', $rendered, $idMatches);
    preg_match('/for="([^"]+)"/', $rendered, $forMatches);

    expect($idMatches)->not->toBeEmpty();
    expect($forMatches)->not->toBeEmpty();
    expect($idMatches[1])->toBe($forMatches[1]);
});

it('test_checked_attribute_applied', function () {
    $view = $this->blade('<x-jetax-checkbox :checked="true" />');

    $view->assertSee('checked', false);
});

it('test_consumer_class_reaches_checkbox_input', function () {
    $html = Blade::render('<x-jetax-checkbox name="aceite" label="Aceite" class="mt-0.5" />');

    expect(tagClass(htmlTag($html, 'input', 'type="checkbox"')))->toContain('mt-0.5');
    expect(tagClass(htmlTag($html, 'div')))->not->toContain('mt-0.5');
});

it('test_checked_and_focus_states_use_primary_token', function () {
    $html = Blade::render('<x-jetax-checkbox name="aceite" />');

    expect($html)
        ->toContain('checked:bg-primary')
        ->toContain('checked:border-primary')
        ->toContain('focus:ring-primary')
        ->not->toContain('#0061a5');
});

it('test_resting_state_uses_surface_tokens', function () {
    $html = Blade::render('<x-jetax-checkbox name="aceite" />');

    expect($html)
        ->toContain('border-outline-variant')
        ->toContain('bg-surface-input')
        ->not->toContain('bg-[#f3f3ff]')
        ->not->toContain('border-[#e2e6f1]');
});

it('test_label_uses_on_surface_token', function () {
    $html = Blade::render('<x-jetax-checkbox name="aceite" label="Aceito os termos" />');

    expect(tagClass(htmlTag($html, 'label')))->toContain('text-on-surface');
    expect($html)->not->toContain('text-[#');
});

it('test_id_is_deterministic_from_name', function () {
    $first = Blade::render('<x-jetax-checkbox name="aceite" label="Aceite" />');
    $second = Blade::render('<x-jetax-checkbox name="aceite" label="Aceite" />');

    expect($first)->toContain('id="checkbox_aceite"')->toContain('for="checkbox_aceite"');
    expect($second)->toContain('id="checkbox_aceite"');
});

it('test_checkbox_files_have_no_hex_color', function () {
    $root = __DIR__.'/../..';
    $contents = file_get_contents($root.'/resources/views/components/checkbox.blade.php')
        .file_get_contents($root.'/src/View/Components/Checkbox.php');

    expect($contents)->not->toMatch('/(?:text|bg|border|ring|from|to|fill|stroke)-\[#/');
});
