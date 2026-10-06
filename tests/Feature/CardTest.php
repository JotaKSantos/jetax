<?php

use Illuminate\Support\Facades\Blade;
use Jetax\DesignSystem\View\Components\Card;

it('test_has_shadow_class', function () {
    $view = $this->blade('<x-jetax-card>Conteúdo</x-jetax-card>');

    $view->assertSee('shadow-on-surface/5', false);
});

it('test_default_background_uses_surface_token', function () {
    $view = $this->blade('<x-jetax-card>Conteúdo</x-jetax-card>');

    $view->assertSee('bg-surface-container-lowest', false);
    $view->assertDontSee('bg-white', false);
    $view->assertDontSee('#161B2A', false);
});

it('test_dark_mode_has_subtle_border', function () {
    $view = $this->blade('<x-jetax-card>Conteúdo</x-jetax-card>');

    $view->assertSee('dark:border-outline-variant', false);
});

it('test_bordered_variant', function () {
    $view = $this->blade('<x-jetax-card :bordered="true">Conteúdo</x-jetax-card>');

    $view->assertSee('border', false);
    $view->assertSee('shadow-sm', false);
    $view->assertDontSee('shadow-[0_4px_20px', false);
});

it('test_header_uses_secondary_in_light_and_primary_in_dark', function () {
    $view = $this->blade(
        '<x-jetax-card>Conteúdo<x-slot:header>Título</x-slot:header></x-jetax-card>'
    );

    $view->assertSee('bg-secondary/5', false);
    $view->assertSee('dark:bg-primary/5', false);
});

it('test_footer_uses_surface_container_low', function () {
    $view = $this->blade(
        '<x-jetax-card>Conteúdo<x-slot:footer>Rodapé</x-slot:footer></x-jetax-card>'
    );

    $view->assertSee('bg-surface-container-low', false);
});

it('test_featured_variant', function () {
    $view = $this->blade('<x-jetax-card :featured="true">Conteúdo</x-jetax-card>');

    $view->assertSee('border-t-4', false);
    $view->assertSee('border-error', false);
});

it('test_header_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-card>Corpo<x-slot:header>Título do Card</x-slot:header></x-jetax-card>'
    );

    $view->assertSee('Título do Card');
});

it('test_footer_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-card>Corpo<x-slot:footer>Rodapé do Card</x-slot:footer></x-jetax-card>'
    );

    $view->assertSee('Rodapé do Card');
});

it('test_header_class_prop_appended', function () {
    $view = $this->blade(
        '<x-jetax-card header-class="custom-header-x">Corpo<x-slot:header>Título</x-slot:header></x-jetax-card>'
    );

    $view->assertSee('custom-header-x', false);
    $view->assertSee('bg-secondary/5', false);
});

it('test_footer_class_prop_appended', function () {
    $view = $this->blade(
        '<x-jetax-card footer-class="custom-footer-y">Corpo<x-slot:footer>Rodapé</x-slot:footer></x-jetax-card>'
    );

    $view->assertSee('custom-footer-y', false);
    $view->assertSee('bg-surface-container-low', false);
});

it('test_consumer_padding_classes_reach_body_wrapper', function () {
    $html = Blade::render('<x-jetax-card class="p-0 md:p-6 mb-4">Corpo</x-jetax-card>');

    preg_match_all('/<div\b[^>]*>/', $html, $divs);
    [$container, $body] = [tagClass($divs[0][0]), tagClass($divs[0][1])];

    expect($body)->toContain('p-0 md:p-6')->not->toContain('p-6 p-0');
    expect($container)->toContain('mb-4')->not->toContain('p-0')->not->toContain('md:p-6');
    expect($html)->not->toContain('style="padding:');
});

it('test_axis_padding_classes_keep_default_padding', function () {
    $html = Blade::render('<x-jetax-card class="px-0 sm:py-2">Corpo</x-jetax-card>');

    preg_match_all('/<div\b[^>]*>/', $html, $divs);

    expect(tagClass($divs[0][1]))->toBe('p-6 px-0 sm:py-2');
});

it('test_padding_prop_zero_still_works', function () {
    $html = Blade::render('<x-jetax-card padding="0">Corpo</x-jetax-card>');

    preg_match_all('/<div\b[^>]*>/', $html, $divs);

    expect(tagClass($divs[0][1]))->toBe('p-0');
    expect($html)->not->toContain('style="padding:');
});

it('test_default_padding_is_p6_by_class', function () {
    $html = Blade::render('<x-jetax-card>Corpo</x-jetax-card>');

    preg_match_all('/<div\b[^>]*>/', $html, $divs);

    expect(tagClass($divs[0][1]))->toBe('p-6');
});

it('test_container_classes_have_no_literal_colors', function () {
    foreach ([[], ['featured' => true], ['bordered' => true]] as $props) {
        $classes = (new Card(...$props))->containerClasses();

        expect($classes)
            ->toContain('bg-surface-container-lowest')
            ->not->toContain('bg-white')
            ->not->toContain('#161B2A')
            ->not->toContain('#');
    }
});

it('test_detects_padding_classes', function () {
    foreach (['p-0', 'px-4', 'py-2', 'pt-1', 'md:p-6', 'lg:px-8', '!p-0', 'p-[18px]'] as $class) {
        expect(Card::isPaddingClass($class))->toBeTrue();
    }

    foreach (['mb-4', 'pointer-events-none', 'place-items-center', 'shadow-none', 'md:mb-2'] as $class) {
        expect(Card::isPaddingClass($class))->toBeFalse();
    }
});
