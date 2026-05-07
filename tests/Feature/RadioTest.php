<?php

it('test_renders_radio_input', function () {
    $view = $this->blade('<x-jetax-radio />');

    $view->assertSee('type="radio"', false);
    $view->assertSee('<input', false);
});

it('test_name_and_value_attributes', function () {
    $view = $this->blade('<x-jetax-radio name="pagamento" value="cartao" />');

    $view->assertSee('name="pagamento"', false);
    $view->assertSee('value="cartao"', false);
});

it('test_label_is_associated', function () {
    $view = $this->blade('<x-jetax-radio label="Cartão de crédito" name="pagamento" value="cartao" />');

    $rendered = (string) $view;

    preg_match('/id="([^"]+)"/', $rendered, $idMatches);
    preg_match('/for="([^"]+)"/', $rendered, $forMatches);

    expect($idMatches)->not->toBeEmpty();
    expect($forMatches)->not->toBeEmpty();
    expect($idMatches[1])->toBe($forMatches[1]);
});
