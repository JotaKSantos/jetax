<?php

it('renders correct number of stars', function () {
    $view = $this->blade('<x-jetax-rating :max="7" />');
    // Check the max appears in alpine data
    $view->assertSee('max: 7', false);
    // Check star icons are present
    expect($view->__toString())->toContain('star');
});

it('disables interaction in readonly mode', function () {
    $view = $this->blade('<x-jetax-rating :readonly="true" :value="3" />');
    $html = $view->__toString();
    $view->assertSee('readonly: true', false);
});

it('renders hidden input with wire:model', function () {
    $view = $this->blade('<x-jetax-rating name="score" wire:model="score" />');
    $view->assertSee('wire:model', false);
});

it('applies size classes', function () {
    $view = $this->blade('<x-jetax-rating size="lg" />');
    $view->assertSee('32px', false);
});
