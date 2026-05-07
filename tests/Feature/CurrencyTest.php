<?php

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

    $view->assertSee('border-red-500', false);
});
