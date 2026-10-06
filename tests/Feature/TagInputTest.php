<?php

use Illuminate\Support\Facades\Blade;

it('test_renders_input_for_tag_entry', function () {
    $view = $this->blade('<x-jetax-tag-input />');

    $view->assertSee('type="text"', false);
    $view->assertSee('Adicionar tag...', false);
});

it('test_wire_model_on_hidden_array_input', function () {
    $html = (string) $this->blade('<x-jetax-tag-input wire:model="tags" />');

    expect(htmlTag($html, 'input', 'type="hidden"'))->toContain('wire:model="tags"')
        ->and(substr_count($html, 'wire:model'))->toBe(1);
});

it('test_disabled_state_blocks_input', function () {
    $view = $this->blade('<x-jetax-tag-input :disabled="true" />');

    $view->assertSee('disabled: true', false);
    $view->assertSee(':disabled="disabled"', false);
});

it('test_keeps_alpine_tag_behavior', function () {
    $html = (string) $this->blade('<x-jetax-tag-input :suggestions="[\'PHP\', \'Laravel\']" :max="3" />');

    expect($html)->toContain('addTag(value)')
        ->toContain('removeTag(index)')
        ->toContain('max: 3')
        ->toContain('&quot;PHP&quot;');
});

it('test_merges_consumer_class_in_single_root_class', function () {
    $html = (string) $this->blade('<x-jetax-tag-input class="probe-xyz" data-x="1" />');

    // O `x-data` tem `=>` (arrow function), então a tag raiz vai até o `>` que fecha a linha.
    preg_match('/^\s*<div\b.*?\n>/s', $html, $match);
    $root = $match[0];

    expect($root)->toContain('probe-xyz')
        ->toContain('w-full')
        ->toContain('data-x="1"')
        ->and(substr_count($root, 'class="'))->toBe(1);
});

it('test_uses_tokens_without_hex_or_named_palette', function () {
    $html = (string) $this->blade('<x-jetax-tag-input />');

    expect($html)->not->toMatch('/-\[#[0-9a-fA-F]+\]/')
        ->not->toMatch('/-(slate|gray)-\d/')
        ->toContain('text-on-surface');
});

it('test_tag_alias_is_no_longer_registered', function () {
    $aliases = Blade::getClassComponentAliases();

    expect($aliases)->toHaveKey('jetax-tag-input')
        ->not->toHaveKey('jetax-tag')
        ->and(view()->exists('jetax::components.tag'))->toBeFalse()
        ->and(file_exists(dirname(__DIR__, 2).'/src/View/Components/Tag.php'))->toBeFalse();
});
