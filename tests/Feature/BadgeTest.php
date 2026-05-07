<?php

it('test_all_variants_render', function () {
    $variants = ['success', 'danger', 'warning', 'info', 'neutral'];

    foreach ($variants as $variant) {
        $view = $this->blade('<x-jetax-badge :variant="$variant">Teste</x-jetax-badge>', ['variant' => $variant]);

        $view->assertSee('Teste');
    }
});

it('test_dot_indicator_present', function () {
    $view = $this->blade('<x-jetax-badge variant="success" style="status">Ativo</x-jetax-badge>');

    $view->assertSee('w-2 h-2', false);
    $view->assertSee('rounded-full', false);
});

it('test_soft_has_10_percent_bg', function () {
    $view = $this->blade('<x-jetax-badge variant="success" style="soft">Success</x-jetax-badge>');

    $view->assertSee('bg-green-500/10', false);
});

it('test_solid_has_full_bg', function () {
    $view = $this->blade('<x-jetax-badge variant="success" style="solid">Success</x-jetax-badge>');

    $view->assertSee('bg-green-600', false);
    $view->assertSee('text-white', false);
});

it('test_square_variant_has_smaller_radius', function () {
    $view = $this->blade('<x-jetax-badge variant="neutral" :square="true">Quadrado</x-jetax-badge>');

    $view->assertSee('rounded-lg', false);
    $view->assertDontSee('rounded-full', false);
});

it('test_success_variant_has_green_classes', function () {
    $view = $this->blade('<x-jetax-badge variant="success" style="soft">Success</x-jetax-badge>');

    $view->assertSee('green', false);
});
