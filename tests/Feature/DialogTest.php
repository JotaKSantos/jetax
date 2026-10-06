<?php

it('test_hidden_by_default', function () {
    $view = $this->blade('<x-jetax-dialog id="meu-dialog" title="Confirmar" message="Tem certeza?" />');

    $view->assertSee('x-show', false);
    $view->assertSee('style="display: none;"', false);
});

it('test_title_and_message_rendered', function () {
    $view = $this->blade('<x-jetax-dialog id="dlg1" title="Excluir item" message="Esta ação não pode ser desfeita." />');

    $view->assertSee('Excluir item');
    $view->assertSee('Esta ação não pode ser desfeita.');
});

it('test_confirm_button_has_danger_variant_by_default', function () {
    $view = $this->blade('<x-jetax-dialog id="dlg2" title="Confirmar" message="Mensagem" />');

    // O botão de confirmação com variante danger usa o token sólido de perigo
    $view->assertSee('bg-danger-solid', false);
});

it('test_custom_labels_applied', function () {
    $view = $this->blade('<x-jetax-dialog id="dlg3" title="Atenção" message="Mensagem" confirm-label="Sim, excluir" cancel-label="Não, manter" />');

    $view->assertSee('Sim, excluir');
    $view->assertSee('Não, manter');
});

it('test_aria_alertdialog_role', function () {
    $view = $this->blade('<x-jetax-dialog id="dlg4" title="Confirmar" message="Mensagem" />');

    $view->assertSee('role="alertdialog"', false);
    $view->assertSee('aria-modal="true"', false);
});

it('test_cancel_button_present', function () {
    $view = $this->blade('<x-jetax-dialog id="dlg5" title="Confirmar" message="Mensagem" cancel-label="Voltar" />');

    $view->assertSee('Voltar');
});

it('test_dispatches_confirmed_event', function () {
    $view = $this->blade('<x-jetax-dialog id="dlg6" title="Confirmar" message="Mensagem" />');

    $view->assertSee('dialog-confirmed', false);
});

it('test_dispatches_cancelled_event', function () {
    $view = $this->blade('<x-jetax-dialog id="dlg7" title="Confirmar" message="Mensagem" />');

    $view->assertSee('dialog-cancelled', false);
});

/*
|--------------------------------------------------------------------------
| API absorvida do override do VetSoft (overrides-api.md § dialog)
|--------------------------------------------------------------------------
*/

/**
 * Diálogo com corpo livre pelo slot default, nos ids do contrato de ARIA.
 */
function dialogSlotBody(string $attributes = ''): string
{
    return '<x-jetax-dialog id="d1" confirm-label="Desfazer" cancel-label="Voltar" '.$attributes.'>
        <h3 id="d1-title">Desfazer baixa?</h3>
        <p id="d1-message">O título volta para <strong>Em aberto</strong>.</p>
    </x-jetax-dialog>';
}

/**
 * Diálogo com slot `footer`: painel largo, rodapé com fundo próprio.
 */
function dialogWithFooter(string $attributes = ''): string
{
    return '<x-jetax-dialog id="d1" '.$attributes.'>
        <h3 id="d1-title">Transferir agendamentos</h3>
        <p id="d1-message">Escolha o novo profissional.</p>
        <x-slot:footer><button type="button" data-consumer-footer-button>Transferir</button></x-slot:footer>
    </x-jetax-dialog>';
}

it('test_slot_body_replaces_generated_icon_title_and_message', function () {
    $html = (string) $this->blade(dialogSlotBody());

    expect($html)->toContain('Desfazer baixa?')
        ->toContain('<strong>Em aberto</strong>')
        ->not->toContain('material-symbols-outlined text-5xl')
        ->not->toContain('<h2');
});

it('test_slot_body_keeps_aria_ids_contract', function () {
    $html = (string) $this->blade(dialogSlotBody());

    $root = htmlTag($html, 'div', 'role="alertdialog"');

    expect($root)->toContain('aria-labelledby="d1-title"')
        ->toContain('aria-describedby="d1-message"')
        ->and($html)->toContain('<h3 id="d1-title">Desfazer baixa?</h3>')
        ->toContain('<p id="d1-message">');
});

it('test_slot_body_buttons_are_right_aligned_and_auto_width', function () {
    $html = (string) $this->blade(dialogSlotBody());

    expect($html)->toContain('flex items-center justify-end gap-3')
        ->and(htmlTag($html, 'button', 'data-dialog-cancel'))->not->toContain('flex-1')
        ->and(htmlTag($html, 'button', 'data-dialog-confirm'))->not->toContain('flex-1');
});

it('test_slot_body_cancel_button_has_data_anchor', function () {
    $html = (string) $this->blade(dialogSlotBody());

    expect(htmlTag($html, 'button', 'data-dialog-cancel'))->toContain('data-dialog-cancel="d1"')
        ->toContain("\$dispatch('dialog-cancelled', { id: 'd1' })")
        ->and($html)->toContain('Voltar');
});

it('test_slot_body_confirm_button_has_data_anchor', function () {
    $html = (string) $this->blade(dialogSlotBody());

    expect(htmlTag($html, 'button', 'data-dialog-confirm'))->toContain('data-dialog-confirm="d1"')
        ->toContain("\$dispatch('dialog-confirmed', { id: 'd1' })")
        ->and($html)->toContain('Desfazer');
});

it('test_confirm_disabled_disables_confirm_button', function () {
    $disabled = htmlTag((string) $this->blade(dialogSlotBody(':confirm-disabled="true"')), 'button', 'data-dialog-confirm');
    $enabled = htmlTag((string) $this->blade(dialogSlotBody(':confirm-disabled="false"')), 'button', 'data-dialog-confirm');

    expect($disabled)->toMatch('/\sdisabled[\s>]/')
        ->toContain('aria-disabled="true"')
        ->toContain('pointer-events-none')
        ->and($enabled)->not->toMatch('/\sdisabled[\s>]/')
        ->not->toContain('aria-disabled')
        ->not->toContain('pointer-events-none');
});

it('test_confirm_disabled_does_not_leak_as_attribute', function () {
    $html = (string) $this->blade(dialogSlotBody(':confirm-disabled="true"'));

    expect($html)->not->toContain('confirm-disabled=')
        ->not->toContain('confirmDisabled');
});

it('test_footer_slot_renders_wide_top_anchored_panel', function () {
    $html = (string) $this->blade(dialogWithFooter());

    $root = htmlTag($html, 'div', 'role="alertdialog"');
    $panel = htmlTag($html, 'div', 'data-dialog-panel="d1"');

    expect($panel)->toContain('max-w-[680px]')
        ->and($root)->toContain('items-start')
        ->toContain('py-16')
        ->not->toContain('items-center');
});

it('test_footer_slot_owns_the_footer_and_buttons', function () {
    $html = (string) $this->blade(dialogWithFooter());

    $footer = htmlTag($html, 'div', 'data-dialog-footer="d1"');

    expect($footer)->toContain('border-t')
        ->toContain('bg-surface-container')
        ->and($html)->toMatch('/data-dialog-footer="d1"[^>]*>\s*<button type="button" data-consumer-footer-button>Transferir<\/button>/')
        ->not->toContain('data-dialog-cancel')
        ->not->toContain('data-dialog-confirm')
        ->toContain('Transferir agendamentos');
});

it('test_narrow_panel_width_limits_footer_panel_to_480px', function () {
    $narrow = htmlTag((string) $this->blade(dialogWithFooter('panel-width="narrow"')), 'div', 'data-dialog-panel="d1"');
    $slotOnly = (string) $this->blade(dialogSlotBody('panel-width="narrow"'));

    expect($narrow)->toContain('max-w-[480px]')
        ->not->toContain('max-w-[680px]')
        ->and(htmlTag($slotOnly, 'div', 'data-dialog-panel="d1"'))->toContain('max-w-md')
        ->not->toContain('max-w-[480px]')
        ->and($slotOnly)->not->toContain('panel-width=');
});

it('test_invalid_panel_width_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-dialog id="d1" panel-width="huge" />'))
        ->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_without_slot_renders_package_default_body', function () {
    $html = (string) $this->blade('<x-jetax-dialog id="d1" title="Excluir?" message="Não dá para desfazer." />');

    expect($html)->toContain('material-symbols-outlined text-5xl')
        ->toMatch('/<h2\s+id="d1-title"/')
        ->toMatch('/<p\s+id="d1-message"/')
        ->and(htmlTag($html, 'button', 'data-dialog-cancel'))->toContain('flex-1')
        ->and(htmlTag($html, 'button', 'data-dialog-confirm'))->toContain('flex-1');
});

it('test_listens_to_dialog_open_and_close_window_events', function () {
    $root = htmlTag((string) $this->blade(dialogSlotBody()), 'div', 'role="alertdialog"');

    expect($root)->toContain("x-on:dialog-open.window=\"if (\$event.detail && \$event.detail.id === 'd1') open = true\"")
        ->toContain("x-on:dialog-close.window=\"if (\$event.detail && \$event.detail.id === 'd1') open = false\"");
});

it('test_merges_consumer_class_in_single_root_class', function () {
    $root = htmlTag((string) $this->blade('<x-jetax-dialog id="d1" class="probe-xyz" data-x="1" />'), 'div', 'role="alertdialog"');

    expect($root)->toContain('probe-xyz')
        ->toContain('fixed inset-0 z-50')
        ->toContain('data-x="1"')
        ->and(substr_count($root, 'class="'))->toBe(1);
});

it('test_variants_use_tokens_without_named_palette', function (string $variant, string $button, string $icon) {
    $html = (string) $this->blade('<x-jetax-dialog id="d1" title="T" message="M" :variant="$variant" />', ['variant' => $variant]);

    expect($html)->toContain($button)
        ->toContain($icon)
        ->not->toMatch('/\b(bg|text|hover:bg)-(red|green|amber|blue|slate|gray)-\d/')
        ->not->toMatch('/-\[#[0-9a-fA-F]+\]/');
})->with([
    ['danger', 'bg-danger-solid', 'text-error'],
    ['warning', 'bg-warning-solid', 'text-warning'],
    ['primary', 'bg-primary', 'text-primary'],
    ['success', 'bg-success-solid', 'text-success-text'],
]);
