<?php

use Jetax\DesignSystem\View\Components\Icon;

it('test_renders_material_symbol_element', function () {
    $view = $this->blade('<x-jetax-icon name="settings" />');

    $view->assertSee('material-symbols-outlined', false);
});

it('test_name_as_text_content', function () {
    $view = $this->blade('<x-jetax-icon name="home" />');

    $view->assertSee('home', false);
});

it('test_size_class_applied', function () {
    $sm = $this->blade('<x-jetax-icon name="star" size="sm" />');
    $md = $this->blade('<x-jetax-icon name="star" size="md" />');
    $lg = $this->blade('<x-jetax-icon name="star" size="lg" />');
    $xl = $this->blade('<x-jetax-icon name="star" size="xl" />');

    $sm->assertSee('font-size: 16px', false);
    $md->assertSee('font-size: 20px', false);
    $lg->assertSee('font-size: 24px', false);
    $xl->assertSee('font-size: 32px', false);
});

it('test_fill_variation_classes', function () {
    $filled = $this->blade('<x-jetax-icon name="star" :fill="true" />');
    $outline = $this->blade('<x-jetax-icon name="star" :fill="false" />');

    $filled->assertSee('FILL', false);
    $filled->assertSee("'FILL' 1", false);

    $outline->assertSee('FILL', false);
    $outline->assertSee("'FILL' 0", false);
});
