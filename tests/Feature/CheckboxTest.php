<?php

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
