<?php

use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;

it('test_renders_editor_container', function () {
    $view = $this->blade('<x-jetax-editor />');

    $view->assertSee('data-editor-container', false);
});

it('test_toolbar_buttons_present', function () {
    $view = $this->blade('<x-jetax-editor />');

    $view->assertSee('data-editor-toolbar', false);
    $view->assertSee('data-action="bold"', false);
    $view->assertSee('data-action="italic"', false);
    $view->assertSee('data-action="orderedList"', false);
});

it('test_wire_model_hidden_input', function () {
    $view = $this->blade('<x-jetax-editor wire:model="conteudo" />');

    $view->assertSee('type="hidden"', false);
    $view->assertSee('wire:model', false);
});

it('test_placeholder_applied', function () {
    $view = $this->blade('<x-jetax-editor placeholder="Digite aqui..." />');

    $view->assertSee('data-placeholder="Digite aqui..."', false);
});

/**
 * Recorta o atributo `x-data` do contêiner do editor.
 */
function editorXData(string $html): string
{
    preg_match('/x-data="(\{.*?\})"\s+@editor-insert/s', $html, $match);

    return html_entity_decode($match[1] ?? '', ENT_QUOTES, 'UTF-8');
}

it('test_value_hydrates_initial_content', function () {
    $xData = editorXData((string) $this->blade('<x-jetax-editor value="<p>Oi</p>" />'));

    expect($xData)->toContain('content: '.Js::from('<p>Oi</p>').',')
        ->and($xData)->not->toContain("content: '',");
});

it('test_string_value_is_decoded_back_from_blade_escape', function () {
    $xData = editorXData((string) $this->blade(
        '<x-jetax-editor :value="$corpo" />',
        ['corpo' => '<p>Para <strong>Thor</strong></p>']
    ));

    expect($xData)->toContain('content: '.Js::from('<p>Para <strong>Thor</strong></p>').',')
        ->and($xData)->not->toContain('&lt;');
});

it('test_htmlable_value_is_not_decoded', function () {
    $xData = editorXData((string) $this->blade(
        '<x-jetax-editor :value="$corpo" />',
        ['corpo' => new HtmlString('&lt;b&gt;')]
    ));

    expect($xData)->toContain('content: '.Js::from('&lt;b&gt;').',');
});

it('test_slot_is_fallback_initial_content', function () {
    $xData = editorXData((string) $this->blade('<x-jetax-editor><p>Do slot</p></x-jetax-editor>'));

    expect($xData)->toContain('content: '.Js::from('<p>Do slot</p>').',');
});

it('test_wire_model_hydrates_initial_content', function () {
    $xData = editorXData((string) $this->blade('<x-jetax-editor wire:model="body" />'));

    expect($xData)->toContain("content: \$wire.get('body') ?? ''")
        ->and($xData)->not->toMatch("/content: '',/");

    $withValue = editorXData((string) $this->blade('<x-jetax-editor wire:model.live="form.body" value="<p>Oi</p>" />'));

    expect($withValue)->toContain("content: \$wire.get('form.body') ?? ".Js::from('<p>Oi</p>'));
});

it('test_rehydrates_when_server_changes_content', function () {
    $xData = editorXData((string) $this->blade('<x-jetax-editor wire:model="body" />'));

    expect($xData)->toMatch("/\\\$watch\('content', \(value\) => \{.*?this\.hydrate\(value\)/s")
        ->and($xData)->toContain('this.$wire.$watch(this.wireModel');
});

it('test_editor_key_is_rendered_on_container', function () {
    $keyed = (string) $this->blade('<x-jetax-editor data-editor-key="corpo" />');

    expect($keyed)->toMatch('/<div\s+data-editor-container\s+data-editor-key="corpo"/');

    $unkeyed = (string) $this->blade('<x-jetax-editor />');

    preg_match('/data-editor-key="([^"]+)"/', $unkeyed, $key);
    preg_match('/id="(editor_[^"]+)"/', $unkeyed, $id);

    expect($key[1])->toBe($id[1]);
});

it('test_editor_insert_event_is_filtered_by_editor_key', function () {
    $html = (string) $this->blade('<x-jetax-editor data-editor-key="corpo" />');

    expect($html)->toContain('@editor-insert.window="if ($event.detail.editor === editorKey) { insertAtCursor($event.detail.text) }"')
        ->and(editorXData($html))->toContain("editorKey: 'corpo'");
});

it('test_insert_uses_saved_selection', function () {
    $html = (string) $this->blade('<x-jetax-editor />');
    $xData = editorXData($html);

    expect($xData)->toContain('saveSelection()')
        ->and($xData)->toContain('restoreSelection()')
        ->and($xData)->toContain('insertAtCursor(text)')
        ->and($html)->toContain('@keyup="saveSelection(); syncContent()"')
        ->and($html)->toContain('@mouseup="saveSelection()"')
        ->and($html)->toContain('@blur="saveSelection()"');
});

it('test_readonly_locks_editing_without_dimming', function () {
    $html = (string) $this->blade('<x-jetax-editor readonly />');

    expect($html)->toContain('data-editor-readonly')
        ->and($html)->toContain('aria-readonly="true"')
        ->and($html)->toContain('contenteditable="false"')
        ->and($html)->not->toContain('opacity-50')
        ->and(editorXData($html))->toContain('disabled: true');
});

it('test_disabled_still_dims_the_block', function () {
    $html = (string) $this->blade('<x-jetax-editor disabled />');

    expect($html)->toContain('opacity-50')
        ->and($html)->not->toContain('data-editor-readonly');
});

it('test_without_link_hides_link_button', function () {
    $without = (string) $this->blade('<x-jetax-editor without-link />');
    $with = (string) $this->blade('<x-jetax-editor />');

    expect($without)->not->toContain('data-action="link"')
        ->and($without)->not->toContain('data-editor-link-field')
        ->and($with)->toContain('data-action="link"');
});

it('test_link_button_does_not_use_native_prompt', function () {
    $html = (string) $this->blade('<x-jetax-editor />');

    expect($html)->not->toContain('prompt(')
        ->and($html)->toContain('data-editor-link-field')
        ->and($html)->toContain('@click="openLink()"')
        ->and($html)->toContain('@keydown.enter.prevent="applyLink()"');
});

it('test_does_not_call_tiptap_bootstrap', function () {
    expect((string) $this->blade('<x-jetax-editor />'))->not->toContain('initTiptapEditor');
});

it('test_sync_writes_hidden_value_before_dispatching_input', function () {
    $xData = editorXData((string) $this->blade('<x-jetax-editor />'));

    $write = strpos($xData, 'this.$refs.hiddenInput.value = this.content');
    $dispatch = strpos($xData, "dispatchEvent(new Event('input'");

    expect($write)->not->toBeFalse()
        ->and($dispatch)->not->toBeFalse()
        ->and($write)->toBeLessThan($dispatch);
});

it('test_toolbar_uses_tokens_without_hex_literals', function () {
    $html = (string) $this->blade('<x-jetax-editor />');

    preg_match('/<button\b[^>]*data-action="bold"[^>]*>/s', $html, $bold);

    expect($bold[0])->toContain('text-on-surface-variant')
        ->and($html)->not->toContain('text-[#')
        ->and($html)->not->toContain('bg-[#')
        ->and($html)->not->toContain('border-[#');
});
