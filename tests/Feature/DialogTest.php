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

    // O botão de confirmação com variante danger usa classes red
    $view->assertSee('bg-red-600', false);
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
