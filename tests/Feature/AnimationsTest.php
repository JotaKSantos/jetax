<?php

/**
 * Templates dos quatro componentes com transição, cobrindo os três ramos do dialog
 * (padrão, corpo livre e rodapé próprio).
 *
 * @return array<string, array{string}>
 */
function animatedComponentTemplates(): array
{
    return [
        'dialog' => ['<x-jetax-dialog id="anim-dialog" title="Confirmar" message="Tem certeza?" />'],
        'dialog com corpo livre' => ['<x-jetax-dialog id="anim-dialog-body" title="Confirmar"><p>Corpo livre</p></x-jetax-dialog>'],
        'dialog com rodapé' => ['<x-jetax-dialog id="anim-dialog-footer" title="Confirmar"><p>Corpo</p><x-slot:footer><button>Ok</button></x-slot:footer></x-jetax-dialog>'],
        'modal' => ['<x-jetax-modal id="anim-modal">Conteúdo</x-jetax-modal>'],
        'dropdown' => ['<x-jetax-dropdown><x-slot:trigger><button>Abrir</button></x-slot:trigger><x-jetax-dropdown-item>Item</x-jetax-dropdown-item></x-jetax-dropdown>'],
        'popover' => ['<x-jetax-popover><button>Abrir</button><x-slot:content>Conteúdo</x-slot:content></x-jetax-popover>'],
    ];
}

/**
 * Bloco de uma regra do jetax.css pelo seletor, sem comentários.
 */
function animationCssRule(string $selector): string
{
    $css = preg_replace('#/\*.*?\*/#s', '', file_get_contents(__DIR__.'/../../resources/css/jetax.css'));

    preg_match('/'.preg_quote($selector, '/').'\s*\{([^}]*)\}/', $css, $match);

    return $match[1] ?? '';
}

it('test_animations_are_enabled_by_default', function () {
    expect(config('jetax.animations'))->toBeTrue();
});

it('test_components_emit_x_transition_when_animations_enabled', function (string $template) {
    config(['jetax.animations' => true]);

    expect((string) $this->blade($template))->toContain('x-transition');
})->with(animatedComponentTemplates());

it('test_components_do_not_emit_x_transition_when_animations_disabled', function (string $template) {
    config(['jetax.animations' => false]);

    $html = (string) $this->blade($template);

    expect($html)->not->toContain('x-transition')
        ->toContain('x-show');
})->with(animatedComponentTemplates());

/*
 * Casos nomeados de overrides-api.md (RF-37, T28): um por override com transição.
 */
it('test_dialog_has_no_transition_when_animations_disabled', function () {
    config(['jetax.animations' => false]);

    $html = (string) $this->blade(animatedComponentTemplates()['dialog'][0]);

    expect($html)->not->toContain('x-transition')->toContain('role="alertdialog"');
});

it('test_dropdown_has_no_transition_when_animations_disabled', function () {
    config(['jetax.animations' => false]);

    $html = (string) $this->blade(animatedComponentTemplates()['dropdown'][0]);

    expect($html)->not->toContain('x-transition')->toContain('x-ref="menu"');
});

it('test_modal_has_no_transition_when_animations_disabled', function () {
    config(['jetax.animations' => false]);

    $html = (string) $this->blade(animatedComponentTemplates()['modal'][0]);

    expect($html)->not->toContain('x-transition')->toContain('x-trap.noscroll');
});

it('test_layouts_mark_html_when_animations_disabled', function (string $template) {
    config(['jetax.animations' => false]);

    expect(htmlTag((string) $this->blade($template), 'html'))->toContain('data-jetax-animations="off"');
})->with([
    'layout' => ['<x-jetax-layout>Conteúdo</x-jetax-layout>'],
    'auth-layout' => ['<x-jetax-auth-layout>Conteúdo</x-jetax-auth-layout>'],
]);

it('test_layouts_do_not_mark_html_when_animations_enabled', function (string $template) {
    config(['jetax.animations' => true]);

    expect(htmlTag((string) $this->blade($template), 'html'))->not->toContain('data-jetax-animations');
})->with([
    'layout' => ['<x-jetax-layout>Conteúdo</x-jetax-layout>'],
    'auth-layout' => ['<x-jetax-auth-layout>Conteúdo</x-jetax-auth-layout>'],
]);

it('test_css_stops_fade_and_slide_when_animations_disabled', function () {
    $css = preg_replace('#/\*.*?\*/#s', '', file_get_contents(__DIR__.'/../../resources/css/jetax.css'));

    preg_match('/\[data-jetax-animations="off"\]\s*:is\(([^)]*)\)\s*\{([^}]*)\}/', $css, $match);

    expect($match)->not->toBe([])
        ->and($match[1])->toContain('.jetax-animate-fade-in')
        ->toContain('.jetax-animate-fade-out')
        ->toContain('.jetax-animate-slide-up')
        ->toContain('.jetax-animate-slide-down')
        ->not->toContain('shimmer')
        ->not->toContain('spin')
        ->and($match[2])->toContain('animation: none');
});

it('test_css_keeps_shimmer_and_spin_animating', function () {
    expect(animationCssRule('.jetax-animate-shimmer'))->toContain('animation: jetax-shimmer')
        ->and(animationCssRule('.jetax-animate-spin'))->toContain('animation: jetax-spin')
        ->and(file_get_contents(__DIR__.'/../../resources/css/jetax.css'))
        ->toContain('@keyframes jetax-shimmer')
        ->toContain('@keyframes jetax-spin');
});
