<?php

it('test_value_sets_width_percentage', function () {
    $view = $this->blade('<x-jetax-progress :value="75" />');

    $view->assertSee('width: 75%', false);
});

it('test_aria_attributes_present', function () {
    $view = $this->blade('<x-jetax-progress :value="50" :max="200" />');

    $view->assertSee('aria-valuenow="50"', false);
    $view->assertSee('aria-valuemin="0"', false);
    $view->assertSee('aria-valuemax="200"', false);
});

it('test_color_classes_applied', function () {
    $view = $this->blade('<x-jetax-progress :value="50" color="primary" />');
    $view->assertSee('bg-[#0061a5]', false);

    $view = $this->blade('<x-jetax-progress :value="50" color="success" />');
    $view->assertSee('bg-emerald-500', false);

    $view = $this->blade('<x-jetax-progress :value="50" color="warning" />');
    $view->assertSee('bg-amber-500', false);

    $view = $this->blade('<x-jetax-progress :value="50" color="danger" />');
    $view->assertSee('bg-red-600', false);
});

it('test_animated_class_when_prop_true', function () {
    $view = $this->blade('<x-jetax-progress :value="50" :animated="true" />');

    $view->assertSee('progress-striped', false);
});
