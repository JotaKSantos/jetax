<?php

it('test_renders_range_input', function () {
    $view = $this->blade('<x-jetax-range />');

    $view->assertSee('type="range"', false);
});

it('test_min_max_step_attributes', function () {
    $view = $this->blade('<x-jetax-range :min="10" :max="200" :step="5" />');

    $view->assertSee('min="10"', false);
    $view->assertSee('max="200"', false);
    $view->assertSee('step="5"', false);
});

it('test_show_value_element_present', function () {
    $view = $this->blade('<x-jetax-range :show-value="true" :value="75" />');

    $view->assertSee('data-range-value', false);
});
