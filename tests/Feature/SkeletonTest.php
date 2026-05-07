<?php

it('test_has_shimmer_animation_class', function () {
    $view = $this->blade('<x-jetax-skeleton />');

    $view->assertSee('jetax-skeleton-shimmer', false);
});

it('test_width_and_height_applied', function () {
    $view = $this->blade('<x-jetax-skeleton width="1/2" height="8" />');

    $view->assertSee('w-1/2', false);
    $view->assertSee('h-8', false);
});

it('test_rounded_class_when_prop_true', function () {
    $view = $this->blade('<x-jetax-skeleton :rounded="true" />');

    $view->assertSee('rounded-full', false);
});
