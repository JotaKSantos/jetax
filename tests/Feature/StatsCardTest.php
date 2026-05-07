<?php

it('test_value_rendered_with_headline_font', function () {
    $view = $this->blade('<x-jetax-stats-card label="Receita" value="R$ 142.380,00" />');

    $view->assertSee('font-headline', false);
});

it('test_up_trend_has_green_class', function () {
    $view = $this->blade('<x-jetax-stats-card label="Receita" value="R$ 142.380,00" trend="up" trend-value="12.5%" />');

    $view->assertSee('text-green-600', false);
});

it('test_down_trend_has_red_class', function () {
    $view = $this->blade('<x-jetax-stats-card label="Inadimplência" value="4.2%" trend="down" trend-value="5.1%" />');

    $view->assertSee('text-error', false);
});

it('test_highlighted_has_gradient_class', function () {
    $view = $this->blade('<x-jetax-stats-card label="Receita" value="R$ 142.380,00" :highlighted="true" />');

    $view->assertSee('primary-gradient', false);
});
